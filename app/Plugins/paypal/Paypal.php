<?php

namespace App\Plugins\paypal;

use App\Helpers\Payment;
use App\Models\Package;
use App\Models\PaymentMethod;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Omnipay\Omnipay;

class Paypal extends Payment {
	/**
	 * Send Payment
	 *
	 * @param Request $request
	 * @param Post $post
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception
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

		// Get Pack infos
		$package = Package::find($request->input('package'));

		// Don't make a payment if 'price' = 0 or null
		if (empty($package) || $package->price <= 0) {
			// echo "if";
			// print_r($package);exit;
			return redirect(parent::$uri['previousUrl'] . '?error=package')->withInput();
		}

		$couponDiscountArray = json_decode($request->input('coupon_discount_array'));
		$paymentMethodDiscountArray = json_decode($request->input('payment_method_discount_array'));

		$price = !empty($package->price) ? $package->price : 0;
		// $tax = !empty($package->tax) ? $package->tax : 0;
		// $tax_amount = ($price * $tax)/100;
		$tax_amount = isset($request->tax) ? $request->tax : 0;
		$totalReminderFees = isset($request->totalReminderFees) ? $request->totalReminderFees : 0;
		// $transaction_amount = round(($price + $tax_amount + $totalReminderFees));
		$transaction_amount = $couponDiscountArray->transaction_amount;
		$additional_charges = isset($request->additional_charges) ? $request->additional_charges : [] ;

		// API Parameters
		$providerParams = [
			'cancelUrl' => parent::$uri['paymentCancelUrl'],
			'returnUrl' => parent::$uri['paymentReturnUrl'],
			'name' => $request->get('email').' ('.$request->get('userId').') ',
			'description' => $request->get('email').' - '.$request->get('userId').' ('. $package->name .')',
			'amount' => $transaction_amount,
			'currency' => $package->currency_code,
			'email' => $request->get('email'),
		];

		Log::info('Payment providerParams', ['Payment Response Array' => $providerParams]);

		// Local Parameters
		$localParams = [
			'payment_method' => $request->get('payment_method'),
			'accept_method' => $request->get('accept_method'),
			'post_id' => $post->id,
			'package_id' => $package->id,
			'transaction_amount' => $transaction_amount,
			'additional_charges' => $additional_charges,
			'is_renew' => $request->get('is_renew'),
			// 'tax' => $request->tax,
			'is_coupon_applied' => isset($couponDiscountArray->is_coupon_applied) ? $couponDiscountArray->is_coupon_applied : 0,
			'is_payment_method_coupon_applied' => isset($paymentMethodDiscountArray->is_payment_coupon_applied) ? $paymentMethodDiscountArray->is_payment_coupon_applied : 0,
			'is_webhook_call' => 0
		];
		
		$coupon_data = array();
		if($localParams['is_coupon_applied'] == 1){

			$coupon_amount = 	isset($couponDiscountArray->discount_coupon_amount) ? $couponDiscountArray->discount_coupon_amount : 0;
			$coupon_tax = 		isset($couponDiscountArray->discount_coupon_tax) ? $couponDiscountArray->discount_coupon_tax : 0;
			$coupon_name = 		isset($couponDiscountArray->coupon_name) ? $couponDiscountArray->coupon_name : '';
			$coupon_id_coupon = isset($couponDiscountArray->crm_coupon_id_coupon) ? $couponDiscountArray->crm_coupon_id_coupon : '';
			$coupon_code = 		isset($couponDiscountArray->crm_coupon) ? $couponDiscountArray->crm_coupon : '';

			$coupon_data[0] = array ( 
							'coupon_amount'     => $coupon_amount,
	                        'coupon_tax'        => $coupon_tax,
	                        'coupon_name'       => $coupon_name,
	                        'coupon_id_coupon'  => $coupon_id_coupon,
	                        'coupon_code' 		=> $coupon_code,
	                        'coupon_type'		=> isset($couponDiscountArray->coupon_type) ? $couponDiscountArray->coupon_type : '',
	                        );
			
			$localParams['coupon_code'] = $coupon_code;
			$localParams['coupon_id'] = $coupon_id_coupon;
			$localParams['coupon_name'] = $coupon_name;
			$localParams['coupon_discount'] = isset($couponDiscountArray->crm_discount) ? $couponDiscountArray->crm_discount : 0;
			$localParams['total_discounted_amount_with_payment_method'] = isset($couponDiscountArray->total_discounted_amount_with_payment_method_coupon) ? $couponDiscountArray->total_discounted_amount_with_payment_method_coupon : 0;
			$localParams['discount_coupon_amount'] = isset($couponDiscountArray->discount_coupon_amount) ? $couponDiscountArray->discount_coupon_amount : 0;
			$localParams['discount_type'] = isset($couponDiscountArray->crm_discount_type) ? $couponDiscountArray->crm_discount_type : 0;
			$localParams['coupon_type'] = isset($couponDiscountArray->coupon_type) ? $couponDiscountArray->coupon_type : '';
			$localParams['coupon_tax'] = $coupon_tax;
		}
		
		if($localParams['is_payment_method_coupon_applied'] == 1){

			$coupon_data[1] = array ( 
							'coupon_amount'     => isset($paymentMethodDiscountArray->payment_method_discount_amount) ? $paymentMethodDiscountArray->payment_method_discount_amount : '',
	                        'coupon_tax'        => isset($paymentMethodDiscountArray->payment_method_discount_tax) ? $paymentMethodDiscountArray->payment_method_discount_tax : '',
	                        'coupon_name'       => isset($paymentMethodDiscountArray->payment_method_discount_name) ? $paymentMethodDiscountArray->payment_method_discount_name : '',
	                        'coupon_id_coupon'  => isset($paymentMethodDiscountArray->payment_method_discount_coupon_id_coupon) ? $paymentMethodDiscountArray->payment_method_discount_coupon_id_coupon : '',
	                        'coupon_code' 		=> isset($paymentMethodDiscountArray->payment_method_discount_coupon_code) ? $paymentMethodDiscountArray->payment_method_discount_coupon_code : '',
	                        'coupon_type'		=> isset($paymentMethodDiscountArray->payment_method_coupon_type) ? $paymentMethodDiscountArray->payment_method_coupon_type : '',
	                        );

			$localParams['payment_method_discount_id'] = isset($paymentMethodDiscountArray->payment_method_discount_id) ? $paymentMethodDiscountArray->payment_method_discount_id : 0;

			$localParams['payment_method_discount_coupon_id_coupon'] = isset($paymentMethodDiscountArray->payment_method_discount_coupon_id_coupon) ? $paymentMethodDiscountArray->payment_method_discount_coupon_id_coupon : 0;
			
			$localParams['payment_method_discount_name'] = isset($paymentMethodDiscountArray->payment_method_discount_name) ? $paymentMethodDiscountArray->payment_method_discount_name : '';

			$localParams['payment_method_discount'] = isset($paymentMethodDiscountArray->payment_method_discount) ? $paymentMethodDiscountArray->payment_method_discount : 0;

			$localParams['payment_method_discount_type'] = isset($paymentMethodDiscountArray->payment_method_discount_type) ? $paymentMethodDiscountArray->payment_method_discount_type : '';
			
			$localParams['payment_method_discount_coupon_code'] = isset($paymentMethodDiscountArray->payment_method_discount_coupon_code) ? $paymentMethodDiscountArray->payment_method_discount_coupon_code : '';

			$localParams['payment_method_discount_amount'] = isset($paymentMethodDiscountArray->payment_method_discount_amount) ? $paymentMethodDiscountArray->payment_method_discount_amount : 0;
			$localParams['payment_method_coupon_type'] = isset($paymentMethodDiscountArray->payment_method_coupon_type) ? $paymentMethodDiscountArray->payment_method_coupon_type : '';
			$localParams['payment_method_discount_tax'] = isset($paymentMethodDiscountArray->payment_method_discount_tax) ? $paymentMethodDiscountArray->payment_method_discount_tax : '';
		}	
		$localParams['coupon_data'] = $coupon_data;
		
		// Local Parameters
		// $localParams = [
		// 	'payment_method' => $request->get('payment_method'),
		// 	'accept_method' => $request->get('accept_method'),
		// 	'post_id' => $post->id,
		// 	'package_id' => $package->id,
		// 	'transaction_amount' => $transaction_amount,
		// 	'additional_charges' => $additional_charges,
		// 	'is_renew' => $request->get('is_renew'),
		// 	'tax' => $request->tax,
		// 	'coupon_data' => $coupon_data,
		// ];
		$localParams = array_merge($localParams, $providerParams);

		// echo "<pre>"; print_r ($localParams); echo "</pre>"; exit();
		
		$response = "";
		
		// Try to make the Payment
		try {
			$gateway = Omnipay::create('PayPal_Express');
			$gateway->setUsername(config('app.paypal_username'));
			$gateway->setPassword(config('app.paypal_password'));
			$gateway->setSignature(config('app.paypal_signature'));
			$gateway->setTestMode((config('app.paypal_mode') == 'sandbox') ? true : false);

			// Card Data
			// $providerParams['card'] = [];

			// Make the payment
			$response = $gateway->purchase($providerParams)->send();

			Log::info('Payment Response', ['Payment Response Array' => $response]);
			Log::info('Payment Response', ['Payment Response Array' => $response->getMessage()]);

			// Save the Transaction ID at the Provider
			$localParams['transaction_id'] = $response->getTransactionId();

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
				// Redirect to offsite payment gateway
				// Redirect to success URL to make the payment on the Paypal website
				\Log::info('===============================================', ['success' => 'failed']);
				\Log::info('Redirect to offsite payment gateway', ['success' => 'false']);
				\Log::info('===============================================', ['success' => 'failed']);
				return $response->redirect();

			} else {
				\Log::info('===============================================', ['success' => 'failed']);
				\Log::info('Apply actions when Payment failed', ['message' => json_encode($response)]);
				\Log::info('===============================================', ['success' => 'failed']);
				// Apply actions when Payment failed
				return parent::paymentFailureActions($post, $response->getMessage());

			}
		} catch (\Exception $e) {

			//store the payment response data
			try{
				parent::logResponse($localParams['email'], $localParams['post_id'], $localParams['payment_method'], $localParams['accept_method'], $response, 'response');
			}catch(\Exception $e){
				\Log::info(' Error while store payment response', ['error' => $e->getMessage()]);
			}

			\Log::info('===============================================', ['success' => 'failed']);
			\Log::info('Apply actions when API failed', ['message' => $e->getMessage()]);
			\Log::info('===============================================', ['success' => 'failed']);
			// Apply actions when API failed
			return parent::paymentApiErrorActions($post, $e);

		}
	}

	/**
	 * @param $params
	 * @param $post
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception
	 */
	public static function paymentConfirmation($params, $post) {

		$token = !empty($post->tmp_token) ? $post->tmp_token : '';
		$title = !empty($post->title) ? $post->title : '';
		$post_id = !empty($post->id) ? $post->id : '';

		// Set form page URL
		parent::$uri['previousUrl'] = str_replace(['#entryToken', '#entryId'], [$token, $post_id], parent::$uri['previousUrl']);
		parent::$uri['nextUrl'] = str_replace(['#entryToken', '#entryId', '#title', '#postId'], [$token, $post_id, slugify(!empty($title) ? $title : '-'), $post_id], parent::$uri['nextUrl']);

		// Try to make the Payment
		try {
			$gateway = Omnipay::create('PayPal_Express');
			$gateway->setUsername(config('app.paypal_username'));
			$gateway->setPassword(config('app.paypal_password'));
			$gateway->setSignature(config('app.paypal_signature'));
			$gateway->setTestMode((config('app.paypal_mode') == 'sandbox') ? true : false);

			// Make the payment
			$response = $gateway->completePurchase($params)->send();
			Log::info('Payment confirmation Response', ['Payment  confirmation Response Array' => $response]);
			// Get raw data
			$rawData = $response->getData();

			//store the payment response data
			try{
				parent::logResponse($params['email'], $post_id, $params['payment_method'], $params['accept_method'], $rawData, 'response');
			}catch(\Exception $e){
				\Log::info(' Error while store payment response', ['error' => $e->getMessage()]);
			}

			if(empty($rawData)){
				Log::error("Payment fail");
				// Apply actions when Payment failed
				return parent::paymentFailureActions($post);
			}

			// Check the Payment
			if (isset($rawData['PAYMENTINFO_0_ACK']) && $rawData['PAYMENTINFO_0_ACK'] === 'Success') {

				// Save the Transaction ID at the Provider (CORRELATIONID | PAYMENTINFO_0_TRANSACTIONID)
				if (isset($rawData['PAYMENTINFO_0_TRANSACTIONID'])) {
					$params['transaction_id'] = $rawData['PAYMENTINFO_0_TRANSACTIONID'];
				}

				// Apply actions after successful Payment
				return parent::paymentConfirmationActions($params, $post);

			} else {

				// Apply actions when Payment failed
				return parent::paymentFailureActions($post);

			}
		} catch (\Exception $e) {
			Log::error($e->getMessage());
			// Apply actions when API failed
			return parent::paymentApiErrorActions($post, $e);

		}
	}

	/**
	 * @return bool
	 */
	public static function installed() {
		$paymentMethod = PaymentMethod::active()->where('name', 'LIKE', 'paypal')->first();
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
			'id' => 1,
			'name' => 'paypal',
			'display_name' => 'Paypal',
			'description' => 'Payment with Paypal',
			'has_ccbox' => 0,
			'lft' => 0,
			'rgt' => 0,
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
		$deletedRows = PaymentMethod::where('name', 'LIKE', 'paypal')->delete();
		if ($deletedRows <= 0) {
			return false;
		}

		return true;
	}
}
