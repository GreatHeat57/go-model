<?php

namespace App\Plugins\stripe;

use App\Helpers\Payment;
use App\Models\Package;
use App\Models\PaymentMethod;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Omnipay\Omnipay;

class Stripe extends Payment {
	/**
	 * Send Payment
	 *
	 * @param Request $request
	 * @param Post $post
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public static function sendPayment(Request $request, Post $post) {

		$token = !empty($post->tmp_token) ? $post->tmp_token : '';
		$title = !empty($post->title) ? $post->title : '';
		$post_id = !empty($post->id) ? $post->id : '';

		// Set URLs
		parent::$uri['previousUrl'] = str_replace(['#entryToken', '#entryId'], [$token, $post_id], parent::$uri['previousUrl']);
		parent::$uri['nextUrl'] = str_replace(['#entryToken', '#entryId', '#title', '#postId'], [$token, $post_id, slugify($title), $post_id], parent::$uri['nextUrl']);
		parent::$uri['paymentCancelUrl'] = str_replace(['#entryToken', '#entryId'], [$token, $post_id], parent::$uri['paymentCancelUrl']);
		parent::$uri['paymentReturnUrl'] = str_replace(['#entryToken', '#entryId'], [$token, $post_id], parent::$uri['paymentReturnUrl']);

		// Get Stripe Token
		$token = $request->input('stripeToken');

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
		// $transaction_amount = round(($price + $tax_amount + $totalReminderFees));
		$transaction_amount = $request->transaction_amount;
		$additional_charges = isset($request->additional_charges) ? $request->additional_charges : [] ;
		// 
		/*$cardExpArr = explode('/', $request->get('stripeCardExpiry'));

		$cardArr = array(
			'firstName'    => $request->get('firstName'),
            'lastName'     => $request->get('lastName'),
            'number'       => $request->get('stripeCardNumber'),
            'expiryMonth'  => $cardExpArr[0],
            'expiryYear'   => $cardExpArr[1],
            'cvv'          => $request->get('stripeCardCVC'),
            'email'        => $request->get('email'),
		);*/

		// API Parameters
		$providerParams = [
			'amount' => $transaction_amount,
			'currency' => $package->currency_code,
			'source' => $token,
			'token' => $token,
			'email' => $request->get('email'),
			'description' => $request->get('email').' - '.$request->get('userId').' ('. $package->name .')'
		];

		// Local Parameters
		$localParams = [
			'payment_method' => $request->get('payment_method'),
			'accept_method' => $request->get('accept_method'),
			'cancelUrl' => parent::$uri['paymentCancelUrl'],
			'returnUrl' => parent::$uri['paymentReturnUrl'],
			'name' => $request->get('email').' ('.$request->get('userId').') ',
			'post_id' => $post->id,
			'package_id' => $package->id,
			'transaction_amount' => $transaction_amount,
			'additional_charges' => $additional_charges,
			'is_renew' => $request->get('is_renew'),
			'tax' => $request->tax,
			'is_coupon_applied' => $request->is_coupon_applied,
		];

		$coupon_data = array();
		if($request->is_coupon_applied == 1){
			$coupon_amount = 	isset($request->discountAmount) ? $request->discountAmount : 0;
			$coupon_tax = 		isset($request->coupon_tax) ? $request->coupon_tax : 0;
			$coupon_name = 		isset($request->crm_coupon_name) ? $request->crm_coupon_name : '';
			$coupon_id_coupon = isset($request->crm_coupon_id_coupon) ? $request->crm_coupon_id_coupon : 0;
			$coupon_code = isset($request->crm_coupon) ? $request->crm_coupon : '';

			$coupon_data = array ( 
							'coupon_amount'     => $coupon_amount,
	                        'coupon_tax'        => $coupon_tax,
	                        'coupon_name'       => $coupon_name,
	                        'coupon_id_coupon'  => $coupon_id_coupon,
	                        'coupon_code' 		=> $coupon_code,
	                        );
			$localParams['coupon_id'] = $coupon_id_coupon;
			$localParams['coupon_code'] = isset($request->coupon_code) ? $request->coupon_code : '';
			$localParams['coupon_name'] = $coupon_name;
			$localParams['coupon_discount'] = isset($request->crm_discount) ? $request->crm_discount : 0;
			$localParams['discounted_amount'] = isset($request->discountAmount) ? $request->discountAmount : 0;
			$localParams['discount_type'] = isset($request->crm_discount_type) ? $request->crm_discount_type : 0;
		}
		$localParams['coupon_data'] = $coupon_data;

		$localParams = array_merge($localParams, $providerParams);

		// Try to make the Payment
		try {

			$gateway = Omnipay::create('Stripe');
			$gateway->setApiKey(config('app.stripe_secret'));

			// $cardObj = $gateway->createCard($cardArr);
			// $providerParams['card'] = $cardObj;


			// Make the payment
			$response = $gateway->purchase($providerParams)->send();

			// Get raw data
			$rawData = $response->getData();

			//store the payment response data
			/*try{
				parent::logResponse($request->get('email'), $post_id, $request->get('payment_method'), $rawData, 'response');
			}catch(\Exception $e){
				\Log::info(' Error while store payment response', ['error' => $e->getMessage()]);
			}*/

			// Save the Transaction ID at the Provider
			if (isset($rawData['id'])) {
				$localParams['transaction_id'] = $rawData['id'];
			}

			// Save local parameters into session
			Session::put('params', $localParams);
			Session::save();

			// Payment by Credit Card when Card info are provide from the form.
			if ($response->isSuccessful()) {

				// Check if redirection to offsite payment gateway is needed
				if ($response->isRedirect()) {
					\Log::info('Check if redirection to offsite payment gateway is needed', ['success' => 'true']);
					return $response->redirect();
				}
				
				\Log::info('Apply actions after successful Payment', ['success' => 'true']);
				// Apply actions after successful Payment
				return self::paymentConfirmationActions($localParams, $post);

			} elseif ($response->isRedirect()) {
				
				\Log::info('===============================================', ['success' => 'false']);
				\Log::info('Redirect to offsite payment gateway', ['success' => 'true']);
				\Log::info('===============================================', ['success' => 'false']);
				// Redirect to offsite payment gateway
				return $response->redirect();

			} else {

				\Log::info('===============================================', ['success' => 'false']);
				\Log::info('Apply actions when Payment failed', ['message' => $e->getMessage()]);
				\Log::info('===============================================', ['success' => 'false']);
				// Apply actions when Payment failed
				return parent::paymentFailureActions($post, $response->getMessage());

			}
		} catch (\Exception $e) {

			\Log::info('===============================================', ['success' => 'false']);
			\Log::info('Apply actions when API failed', ['message' => $e->getMessage()]);
			\Log::info('===============================================', ['success' => 'false']);
			// Apply actions when API failed
			return parent::paymentApiErrorActions($post, $e);

		}
	}

	/**
	 * @param $params
	 * @param $post
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public static function paymentConfirmation($params, $post) {
		// Set form page URL
		Log::info('Payment confirmation stripe page', ['Payment confirmation next url' => 'here']);
		parent::$uri['previousUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], parent::$uri['previousUrl']);
		parent::$uri['nextUrl'] = str_replace(['#entryToken', '#entryId', '#title', '#postId'], [$post->tmp_token, $post->id, slugify($post->title), $post->id], parent::$uri['nextUrl']);

		Log::info('Payment confirmation stripe page', ['Payment confirmation next url' => parent::$uri['nextUrl']]);
		// Apply actions after successful Payment
		return parent::paymentConfirmationActions($params, $post);
	}

	/**
	 * @return bool
	 */
	public static function installed() {
		$paymentMethod = PaymentMethod::active()->where('name', 'LIKE', 'stripe')->first();
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
			'id' => 2,
			'name' => 'stripe',
			'display_name' => 'Stripe',
			'description' => 'Payment with Stripe',
			'has_ccbox' => 1,
			'lft' => 2,
			'rgt' => 2,
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
		$paymentMethod = PaymentMethod::where('name', 'LIKE', 'stripe')->first();
		if (!empty($paymentMethod)) {
			$deleted = $paymentMethod->delete();
			if ($deleted > 0) {
				return true;
			}
		}

		return false;
	}
}
