<?php

namespace App\Plugins\offlinepayment;

use App\Helpers\Payment;
use App\Models\Package;
use App\Models\Payment as PaymentModel;
use App\Models\PaymentMethod;
use App\Models\Post;
use App\Models\User;
use App\Plugins\offlinepayment\app\Mail\PaymentNotification;
use App\Plugins\offlinepayment\app\Notifications\PaymentSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class Offlinepayment extends Payment {
	/**
	 * Send Payment
	 *
	 * @param Request $request
	 * @param Post $post
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public static function sendPayment(Request $request, Post $post) {

		// Messages
		self::$msg['checkout']['success'] = trans('offlinepayment::messages.We have received your offline payment request.') . ' ' .
		trans('offlinepayment::messages.We will wait to receive your payment to process your request.');

		// Set URLs
		parent::$uri['previousUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], parent::$uri['previousUrl']);
		parent::$uri['nextUrl'] = str_replace(['#entryToken', '#entryId', '#title', '#postId'], [$post->tmp_token, $post->id, slugify($post->title), $post->id], parent::$uri['nextUrl']);
		parent::$uri['paymentCancelUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], parent::$uri['paymentCancelUrl']);
		parent::$uri['paymentReturnUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], parent::$uri['paymentReturnUrl']);

		// Get Pack infos
		$package = Package::find($request->input('package'));

		// Don't make a payment if 'price' = 0 or null
		if (empty($package) || $package->price <= 0) {
			return redirect(parent::$uri['previousUrl'] . '?error=package')->withInput();
		}

		$price = !empty($package->price) ? $package->price : 0;
		// $tax = !empty($package->tax) ? $package->tax : 0;
		// $tax_amount = ($price * $tax)/100;
		$tax_amount = isset($request->tax) ? $request->tax : 0;
		$totalReminderFees = isset($request->totalReminderFees) ? $request->totalReminderFees : 0;
		$transaction_amount = round(($price + $tax_amount + $totalReminderFees));
		$additional_charges = isset($request->additional_charges) ? $request->additional_charges : [] ;

		$tax = !empty($package->tax) ? $package->tax : 0;
		$tax_price = ($price * $tax)/100;

		// API Parameters
		$params = [
			'cancelUrl' => parent::$uri['paymentCancelUrl'],
			'returnUrl' => parent::$uri['paymentReturnUrl'],
			'payment_method' => $request->get('payment_method'),
			'post_id' => $post->id,
			'package_id' => $package->id,
			'name' => $package->name,
			'description' => trans('offlinepayment::messages.Ad') . ' #' . $post->id . ' - ' . $package->name,
			'amount' => $transaction_amount,
			'currency' => $package->currency_code,
			'packege_price' => $package->price,
			'tax_price' => $tax_price,
			'additional_charges' => isset($request->additional_charges) ? $request->additional_charges : [],
			'is_renew' => $request->get('is_renew'),
		];

		// Save the Payment in database
		$payment = self::register($post, $params);

		Session::put('params', $params);
		Session::save();

		// Successful transaction
		flash(self::$msg['checkout']['success'])->success();

		// Redirect
		session()->flash('message', self::$msg['post']['success']);

		return redirect(self::$uri['nextUrl']);
	}

	/**
	 * Save the payment and Send payment confirmation email
	 *
	 * @param $post
	 * @param $params
	 * @return PaymentModel
	 */
	public static function register(Post $post, $params) {
		if (empty($post)) {
			return null;
		}

		// Update ad 'reviewed'
		$post->reviewed = 0;
		$post->featured = 0;
		$post->save();

		// Save the payment
		$paymentInfo = [
			'post_id' => $post->id,
			'package_id' => $params['package_id'],
			'payment_method_id' => $params['payment_method'],
			'transaction_id' => (isset($params['transaction_id'])) ? $params['transaction_id'] : null,
			'active' => 0,
			'packege_price' => $params['packege_price'],
			'tax_price' => $params['tax_price'],
			'additional_charges' => $params['additional_charges'],
			'gateway' => 'offlinepayment'
		];
		$payment = new PaymentModel($paymentInfo);
		$payment->save();

		// SEND EMAILS

		// Get all admin users
		$admins = User::where('is_admin', 1)->get();

		// Send Payment Email Notifications
		if (config('settings.mail.payment_email_notification') == 1) {
			

			// payment notification comment by ajay 13-09-2019

			// Send Confirmation Email
			// try {
			// 	$post->notify(new PaymentSent($payment, $post));
			// } catch (\Exception $e) {
			// 	flash($e->getMessage())->error();
			// }

			// Send to Admin the Payment Notification Email
			try {
				if ($admins->count() > 0) {
					foreach ($admins as $admin) {

						Mail::send(new PaymentNotification($payment, $post, $admin));
					}
				}
			} catch (\Exception $e) {
				flash($e->getMessage())->error();
			}
		}

		return $payment;
	}

	/**
	 * @return bool
	 */
	public static function installed() {
		$paymentMethod = PaymentMethod::active()->where('name', 'LIKE', 'offlinepayment')->first();
		if (empty($paymentMethod)) {
			return false;
		}

		return true;
	}

	/**
	 * @return bool
	 */
	public static function install() {
		// Remove the plugin entry
		self::uninstall();

		// Plugin data
		$data = [
			'id' => 5,
			'name' => 'offlinepayment',
			'display_name' => 'Offline Payment',
			'description' => null,
			'has_ccbox' => 0,
			'lft' => 5,
			'rgt' => 5,
			'depth' => 1,
			'active' => 1,
		];

		try {
			// Create plugin data
			$paymentMethod = PaymentMethod::create($data);
			if (empty($paymentMethod)) {
				return false;
			}
		} catch (\Exception $e) {
			return false;
		}

		return true;
	}

	/**
	 * @return bool
	 */
	public static function uninstall() {
		$paymentMethod = PaymentMethod::where('name', 'LIKE', 'offlinepayment')->first();
		if (!empty($paymentMethod)) {
			$deleted = $paymentMethod->delete();
			if ($deleted > 0) {
				return true;
			}
		}

		return false;
	}
}
