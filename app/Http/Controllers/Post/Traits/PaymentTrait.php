<?php
/**
 * JobClass - Geolocalized Job Board Script
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers\Post\Traits;

use App\Models\PaymentMethod;
use App\Models\Post;
use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\VerifiedScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\PaymentIntent;
use Stripe\Source;
use Stripe\Stripe;
use App\Helpers\Payment as PaymentHelper;
use Illuminate\Support\Facades\Log;

trait PaymentTrait {
	/**
	 * Send Payment
	 *
	 * @param Request $request
	 * @param Post $post
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function sendPayment(Request $request, Post $post) {

		// Set URLs

		$this->uri['previousUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], $this->uri['previousUrl']);

		// Get Payment Method
		$paymentMethod = PaymentMethod::find($request->input('payment_method'));

		if (!empty($paymentMethod)) {
			// Load Payment Plugin
			$plugin = load_installed_plugin(strtolower($paymentMethod->name));
			// Payment using the selected Payment Method
			if (!empty($plugin)) {
				
				// Send the Payment
				try {
					return call_user_func($plugin->class . '::sendPayment', $request, $post);
				} catch (\Exception $e) {
					flash($e->getMessage())->error();
					return redirect($this->uri['previousUrl'] . '?error=pluginLoading')->withInput();
				}
			}
		}

		return redirect($this->uri['previousUrl'] . '?error=paymentMethodNotFound')->withInput();
	}

	public function sendPaymentAjax(Request $request, Post $post) {

		$this->uri['previousUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], $this->uri['previousUrl']);

		// Get Payment Method
		$paymentMethod = PaymentMethod::find($request->input('payment_method'));

		if (!empty($paymentMethod)) {
			// Load Payment Plugin
			$plugin = load_installed_plugin(strtolower($paymentMethod->name));
			// Payment using the selected Payment Method
			if (!empty($plugin)) {
				
				// Send the Payment
				try {
					return call_user_func($plugin->class . '::sendPaymentAjax', $request, $post);
				} catch (\Exception $e) {
					flash($e->getMessage())->error();
					return redirect($this->uri['previousUrl'] . '?error=pluginLoading')->withInput();
				}
			}
		}
		return redirect($this->uri['previousUrl'] . '?error=paymentMethodNotFound')->withInput();
	}


	/**
	 * Payment Confirmation
	 * URL: /posts/create/{postIdOrToken}/payment/success
	 * - Success URL when Credit Card is used
	 * - Payment Process URL when no Credit Card is used
	 *
	 * @param $postIdOrToken
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
	 */
	public function paymentConfirmation($postIdOrToken) {
		// Get session parameters
		$params = Session::get('params');
		$post_id = $params['post_id'];

		if (empty($params)) {
			flash($this->msg['checkout']['error'])->error();
			return redirect('/?error=paymentSessionNotFound');
		}

		// Get the entry
		$post = Post::withoutGlobalScopes()->where('id', $post_id)->first();

		if (empty($post)) {
			flash($this->msg['checkout']['error'])->error();
			return redirect('/?error=paymentEntryNotFound');
		}

		// GO TO PAYMENT METHODS

		if (!isset($params['payment_method'])) {
			flash($this->msg['checkout']['error'])->error();
			return redirect('/?error=paymentMethodParameterNotFound');
		}

		// Get Payment Method
		$paymentMethod = PaymentMethod::find($params['payment_method']);
		if (empty($paymentMethod)) {
			flash($this->msg['checkout']['error'])->error();
			return redirect('/?error=paymentMethodEntryNotFound');
		}

		// Load Payment Plugin
		$plugin = load_installed_plugin(strtolower($paymentMethod->name));

		// Check if the Payment Method exists
		if (empty($plugin)) {
			flash($this->msg['checkout']['error'])->error();
			return redirect('/?error=paymentMethodPluginNotFound');
		}

		// Payment using the selected Payment Method
		try {
			return call_user_func($plugin->class . '::paymentConfirmation', $params, $post);
		} catch (\Exception $e) {
			if (Session::has('already_paid')) {
				Log::info('already_paid', ['Payment params Array' => ['param']]);
				if(session('already_paid') == 'yes'){
					Session::forget('already_paid');
					return redirect(config('app.locale').'/'); exit();
				}
			}
			flash($e->getMessage())->error();
			return redirect('/?error=paymentMethodPluginError');
		}
	}

	/**
	 * Payment Cancel
	 * URL: /posts/create/{postIdOrToken}/payment/cancel
	 *
	 * @param $postIdOrToken
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function paymentCancel($postIdOrToken, Request $request) {

		
		// Set the error message
		flash($this->msg['checkout']['cancel'])->error();
		// Get session parameters
		$params = Session::get('params');
		if (empty($params)) {
			return redirect('/?error=paymentCancelled');
		}

		
		// Get ad details
		$post = Post::withoutGlobalScopes()->find($params['post_id']);
		if (empty($post)) {
			return redirect('/?error=paymentCancelled');
		}

		// Delete the Post only if it's new Entry
		if (!empty($post->tmp_token)) {
			// $post->delete();
		}

		// Redirect to the form page
		$this->uri['previousUrl'] = str_replace('#entryId', $postIdOrToken, $this->uri['previousUrl']);

		if(Session::has('redirectTopackages')){
			return redirect(Session::get('redirectTopackages'))->withInput();
		}

		return redirect($this->uri['previousUrl'] . '?error=paymentCancelled')->withInput();
	}

	public function paymentCheck($postIdOrToken, Request $request) {
		Stripe::setApiKey(config('app.stripe_secret'));

		if ($request->get('payment_intent') != null) {
			$paymentIntent = PaymentIntent::retrieve($request->get('payment_intent'));

			if ($paymentIntent->last_payment_error  == null) {
				$this->uri['paymentReturnUrl'] = str_replace(['#entryToken', '#entryId'], [$paymentIntent->metadata->post_tmp_token, $paymentIntent->metadata->post_id], $this->uri['paymentReturnUrl']);
				return redirect($this->uri['paymentReturnUrl']);
			} else {
				$this->uri['paymentCancelUrl'] = str_replace(['#entryToken', '#entryId'], [$paymentIntent->metadata->post_tmp_token, $paymentIntent->metadata->post_id], $this->uri['paymentCancelUrl']);
				return redirect($this->uri['paymentCancelUrl']);
				// var_dump($paymentIntent->last_payment_error);
			}
		}

		if($request->get('source') != null) {
			$source = Source::retrieve($request->get('source'));
			
			// var_dump($source);
			// exit;
			if ($source->status == 'chargeable') {
				$charge = Charge::create([
					'amount' => $source->amount,
					'currency' => $source->currency,
					'source' => $source->id,
					'description' => $source->metadata->email . ' - ' . $source->metadata->user_id . '(' . $source->metadata->package_name . ')',
					'metadata' => [
						'first_name' => $source->metadata->first_name,
						'last_name' => $source->metadata->last_name,
						'user_id' 	=> $source->metadata->user_id,
						'email' => $source->metadata->email,
						'id' 	=> $source->metadata->id,
						'code' 	=> $source->metadata->code,
						'original_currency' => $source->metadata->original_currency,
						'original_amount' => $source->metadata->original_amount,
						'post_id' => $source->metadata->post_id,
						'post_tmp_token' => $source->metadata->post_tmp_token,
						'package_name' => $source->metadata->package_name,
					],
				]);

				if ($charge->status  == 'succeeded' || $charge->status  == 'pending') {
					$this->uri['paymentReturnUrl'] = str_replace(['#entryToken', '#entryId'], [$source->metadata->post_tmp_token, $source->metadata->post_id], $this->uri['paymentReturnUrl']);
					return redirect($this->uri['paymentReturnUrl']);
				} else {
					$this->uri['paymentCancelUrl'] = str_replace(['#entryToken', '#entryId'], [$source->metadata->post_tmp_token, $source->metadata->post_id], $this->uri['paymentCancelUrl']);
					return redirect($this->uri['paymentCancelUrl']);
				}
			} else {
				$this->uri['paymentCancelUrl'] = str_replace(['#entryToken', '#entryId'], [$source->metadata->post_tmp_token, $source->metadata->post_id], $this->uri['paymentCancelUrl']);
				return redirect($this->uri['paymentCancelUrl']);
			}
		}
	}
}
