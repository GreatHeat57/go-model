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

namespace App\Helpers;

use App\Mail\PaymentNotification;
use App\Models\Package;
use App\Models\Payment as PaymentModel;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PaymentSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\paymentLog;
use App\Helpers\CommonHelper;
use App\Models\PaymentMethod;
use App\Models\PaymentCoupon;

class Payment {
	public static $country;
	public static $lang;
	public static $msg = [];
	public static $uri = [];
	public static $accept_method;
	public static $is_webhook_call;
	

	/**
	 * Apply actions after successful Payment
	 *
	 * @param $params
	 * @param $post
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public static function paymentConfirmationActions($params, $post) {

		static::$accept_method = isset($params['accept_method']) ? $params['accept_method'] : '';
		static::$is_webhook_call = isset($params['is_webhook_call']) ? $params['is_webhook_call'] : 0;
		
		// Save the Payment in database
		$payment = self::register($post, $params);
		
		if(static::$accept_method == 'sepa' && static::$is_webhook_call == 1){ return true; }

		Log::info('Payment confirmation helper', ['Payment confirmation next url' => ['post_id' => $payment->post_id, 'package_id' => $payment->post_id, 'payment_method_id' => $payment->payment_method_id, 'transaction_id' => $payment->transaction_id, 'id' => $payment->id ] ]);
		

		if(isset(self::$msg['checkout']['success'])){
			// Successful transaction
			flash(self::$msg['checkout']['success'])->success();
		}
		
		if(isset(self::$msg['post']['success'])){
			// Redirect
			session()->flash('message', self::$msg['post']['success']);
		}

		if(isset(self::$uri['nextUrl'])){
			// Log::info('Payment confirmation', ['Payment confirmation next url' => self::$uri['nextUrl']]);
			return redirect(self::$uri['nextUrl']);
		}
	}

	/**
	 * Apply actions when Payment failed
	 *
	 * @param $post
	 * @param null $errorMessage
	 * @return $this
	 * @throws \Exception
	 */
	public static function paymentFailureActions($post, $errorMessage = null) {
		// Remove the entry
		self::removeEntry($post);

		// Return to Form
		$message = '';
		$message .= self::$msg['checkout']['error'];
		if (!empty($errorMessage)) {
			$message .= '<br>' . $errorMessage;
		}
		// flash($message)->error();
		$request->session()->flash('message', $message);
		// Redirect
		Log::info('Payment failure', ['Payment failure' => $message]);
		return redirect(self::$uri['previousUrl'] . '?error=payment')->withInput();
	}

	/**
	 * Apply actions when API failed
	 *
	 * @param $post
	 * @param $exception
	 * @return $this
	 * @throws \Exception
	 */
	public static function paymentApiErrorActions($post, $exception) {
		// Remove the entry
		self::removeEntry($post);

		// Remove local parameters into the session (if exists)
		if (Session::has('params')) {
			Session::forget('params');
		}

		// Return to Form
		flash($exception->getMessage())->error();

		// Redirect
		return redirect(self::$uri['previousUrl'] . '?error=paymentApi')->withInput();
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
			return false;
		}
		// Update ad 'reviewed'
		$post->reviewed = 1;
		$post->featured = 1;
		$post->save();

		$accept_method = static::$accept_method;
		$is_webhook_call = static::$is_webhook_call;
		// save payment
		$payment = self::savePayment($post, $params);		
		// save payment coupon
		$paymentCoupon = self::savePaymentCoupon($payment, $params);
		
		if(!empty($post->user_id) && !empty($transaction_expiry_date)){
			$user = User::where('id', $post->user_id)->update(['contract_expire_on' => $transaction_expiry_date]);
		}
		// SEND EMAILS

		// Get all admin users
		$admins = User::where('is_admin', 1)->get();

		// Send Payment Email Notifications
		if (config('settings.mail.payment_email_notification') == 1) {
			
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

		$coupon_data = array();
		if($accept_method == 'sepa' && $is_webhook_call == 1){ 
			
			// get payment
			$paymentCoupon = PaymentCoupon::withoutGlobalScope(StrictActiveScope::class)
				->where('payment_id', $payment->id)
				->orderBy('created_at', 'DESC')
				->first();
			if(!empty($paymentCoupon)){
				if($paymentCoupon->coupon_id > 0){
					$coupon_data[0] = array ( 
						'coupon_amount'     => $paymentCoupon->discounted_amount,
	                    'coupon_tax'        => $paymentCoupon->coupon_tax,
	                    'coupon_name'       => $paymentCoupon->coupon_name,
	                    'coupon_id_coupon'  => $paymentCoupon->coupon_id,
	                    'coupon_code' 		=> $paymentCoupon->coupon_code,
	                    'coupon_type'		=> $paymentCoupon->coupon_type,
	                );
				}
				if($paymentCoupon->payment_coupon_id > 0){
	                $coupon_data[1] = array ( 
						'coupon_amount'     => $paymentCoupon->payment_discounted_amount,
                        'coupon_tax'        => $paymentCoupon->payment_coupon_tax,
                        'coupon_name'       => $paymentCoupon->payment_coupon_name,
                        'coupon_id_coupon'  => $paymentCoupon->payment_coupon_id,
                        'coupon_code' 		=> $paymentCoupon->payment_coupon_code,
                        'coupon_type'		=> $paymentCoupon->payment_coupon_type,
	                );
	            }
            }
			$params['coupon_data'] = $coupon_data;
			$params['transaction_id'] = $payment->transaction_id;
		}

		// check current payment method is sepa and function not call via webhook. not call crm api.  
		if($accept_method == 'sepa' && $is_webhook_call == 0){ return $payment; } 
		
		// after successfull payment, register user and generate password
		try {
			self::registerUser($post, $params);
		}catch (\Exception $e) {
			flash($e->getMessage())->error();
		}

		return $payment;
	}

	/**
	 * Remove the ad for public - If there are no free packages
	 *
	 * @param Post $post
	 * @return bool
	 * @throws \Exception
	 */
	public static function removeEntry(Post $post) {
		if (empty($post)) {
			return false;
		}

		// Don't delete the ad when user try to UPGRADE her ads
		if (empty($post->tmp_token)) {
			return false;
		}

		if (Auth::check()) {
			// Delete the ad if user is logged in and there are no free package
			if (Package::where('price', 0)->count() == 0) {
				// But! User can access to the ad from her area to UPGRADE it!
				// You can UNCOMMENT the line below if you don't want the feature above.
				// $post->delete();
			}
		} else {
			// Delete the ad if user is a guest
			$post->delete();
		}

		return true;
	}

	public static function myTransactions($user_id, $perpage = null, $count = null) {

		$Payment = Payment::whereHas('post', function ($query) use ($user_id) {
			$query->currentCountry()->whereHas('user', function ($query) {
				$query->where('user_id', $user_id);
			});
		})
			->with(['post', 'paymentMethod'])
			->orderByDesc('id');

		if ($count) {
			return $Payment->count();
		}

		if ($perpage) {
			return $Payment->paginate($perpage);
		} else {
			return $Payment->get();
		}

	}


	/*
		To store payment logs with request/response params
	*/
	public static function logResponse($email, $post_id, $payment_method, $method_name=null, $response, $stage=null){
		
		// create new object with paymentlog
		$paymentLog = new paymentLog();

		try{
			// store post id, user email, payment method, data as request/response and stage as 'pay','response', or 'cancel'
			$paymentLog->post_id = $post_id;
			$paymentLog->email = $email;
			$paymentLog->payment_method = $payment_method;
			$paymentLog->data = !empty($response)? json_encode($response) : '';
			$paymentLog->stage = $stage;
			$paymentLog->payment_name = $method_name;
			$paymentLog->save();

		}catch(\Exception $e){
			\Log::error('Error while store payment response logResponse', ['error' => $e->getMessage()]);
		}
	}

	// active user and generate the password after sucessfull payment completed
	public static function registerUser($post, $params){
		$is_renew = false;
		$is_update_user_data = false;

		Log::info('Inside the registerUser', ['Request' => 'Inside']);

		// disable to get is_renew param from the session and pass it in payment form post
		if(isset($params['is_renew']) && $params['is_renew'] == 1){
			Log::info('get renew flag in the request param', ['is_renew' => $params['is_renew']]);
			$is_update_user_data = true;
			$is_renew = true;
		}

		// if (session()->has('is_renew')) {
			
		// 	if(session('is_renew') == 1){
		// 		$is_update_user_data = true;
		// 		$is_renew = true;
		// 	}
		// }

		$username = '';
		if (isset($params) && !empty($params)) {

			Log::info('Inside the params', ['params' => 'Inside']);

			$paymentMethods = PaymentMethod::find($params['payment_method']);
			$user = isset($post->user)? $post->user : '';

			$username = ($user->username) ? $user->username : '';

			// CRM api failed send email details
			$crmApiFailedArr = [
                'gocode' => isset($user->profile->go_code) ? $user->profile->go_code : '',
                'username' => $username,
                'email' => isset($user->email) ? $user->email: '',
                'subject' => t('Payment process error'),
                'message' => t('Some error occurred while processing payment please find below details'),
                'payment_method' => $params['accept_method'],
            ];



			//check if payment method is not offline payment then call active user api in CRM
			if ($params['payment_method'] != 5) {

				Log::info('Inside the payment_method', ['payment_method' => 'Inside']);

				$coupon_data = array();

				if(isset($params['coupon_data']) && !empty($params['coupon_data']) && count($params['coupon_data']) > 0){
					$coupon_data = json_encode($params['coupon_data']);
				}
				// get all payment method names crm and laravel
				$paymentMethodNames = config('constant.PAYMENT_METHODS');
				// search crm payment method name in array
				$gateway = array_search ($params['accept_method'], $paymentMethodNames);
				$req_arr = array(
					'action' => 'pay', //required
					'wpusername' => ($user->username) ? $user->username : '', // required
					'transactionid' => $params['transaction_id'],
					'gateway' => !empty($gateway) ? $gateway : $paymentMethods->name,
					'type' => $paymentMethods->name,
					'currency' => $params['currency'],
					'description' => $params['description'],
					'amount' => $params['amount'],
					'coupon_data' => $coupon_data,
					'country_code' => ($user->country_code) ? strtoupper($user->country_code) : '',
				);
				Log::info('Request Array pay', ['Request Array' => $req_arr]);

				try{
                    $response = CommonHelper::go_call_request($req_arr);

                    /*if ($response->getStatusCode() != 200) {
                    	\Log::error("============200 status code Error pay CRM api call ===================");
	                    $crmApiFailedArr['messageDetails'] = $response->getBody();
	                    $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
	                    $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
                    }*/

                }catch(\Exception $e){
                    \Log::error("============ Error failed pay CRM api call ===================");
                    $crmApiFailedArr['messageDetails'] = $e->getMessage();
                    $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
                    $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
                }
				$json = json_decode($response->getBody());
				Log::info('Response Array pay finish', ['Response Array' => $json]);
				Log::info('Response Array staus code finish', ['Response Array staus code' => $response->getStatusCode()]);
				Log::info('is renew', ['Request Array' => $is_renew]);

				if ($response->getStatusCode() == 200) {

					$is_activate_call = true;
					if($is_renew == false){
						
						if($user->password == null || $user->password == ''){
							
							$req_arr = array(
								'action' => 'generate_pw', //required
								'wpusername' => $user->username, // required
								'sendmail' => (!in_array($user->provider, ['google','facebook']))? true : false
							);
							
							Log::info('Request Array generate_pw', ['Request Array' => $req_arr]);
							try{
			                    $response = CommonHelper::go_call_request($req_arr);

			                    /*if ($response->getStatusCode() != 200) {
			                    	\Log::error("============200 status code Error generate_pw CRM api call ===================");
				                    $crmApiFailedArr['messageDetails'] = $response->getBody();
				                    $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
				                    $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
			                    }*/

			                }catch(\Exception $e){
			                    \Log::error("============ Error failed generate_pw CRM api call ===================");
			                    $crmApiFailedArr['messageDetails'] = $e->getMessage();
			                    $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
			                    $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
			                }
							$json = json_decode($response->getBody());
							Log::info('Response Array generate_pw', ['Response Array' => $json]);

							if ($response->getStatusCode() == 200) {
								$body = (string) $response->getBody();
								Log::info('Response Array password', ['Response password' => $body]);


								if(!in_array($user->provider, ['google','facebook'])){
									$user->password = bcrypt($body);
								}
							}else{
								
								$is_activate_call = false;
								if ($response->getStatusCode() != 200) {
			                    	\Log::error("============200 status code Error generate_pw CRM api call else ===================");
				                    $crmApiFailedArr['messageDetails'] = $response->getBody();
				                    $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
				                    $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
			                    }

							}
						}

						if ($is_activate_call == true) {
							
							$req_arr_one = array(
								'action' => 'activate', //required
								'wpusername' => ($user->username) ? $user->username : '', // required
							);

							Log::info('Request Array activate', ['Request Array' => $req_arr_one]);

							try{
			                    $res = CommonHelper::go_call_request($req_arr_one);
			                    
			                    /*if ($res->getStatusCode() != 200) {
			                    	\Log::error("============200 status code Error generate_pw CRM api call ===================");
				                    $crmApiFailedArr['messageDetails'] = $res->getBody();
				                    $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
				                    $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
			                    }*/

			                }catch(\Exception $e){
			                    \Log::error("============ Error failed activate CRM api call ===================");
			                    $crmApiFailedArr['messageDetails'] = $e->getMessage();
			                    $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
			                    $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
			                }

							$json = json_decode($response->getBody());
							Log::info('Response Array activate finish', ['Response Array' => $json]);

							if ($res->getStatusCode() == 200) {
								$is_update_user_data = true;
							}else{
								\Log::error("============ here in activate CRM api call error ===================");

								if ($res->getStatusCode() != 200) {
			                    	\Log::error("============200 status code Error generate_pw CRM api call else ===================");
				                    $crmApiFailedArr['messageDetails'] = $res->getBody();
				                    $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
				                    $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
			                    }
							}
						}
					}

					if($is_update_user_data == true){

						$user->active = 1;
						$user->subscribed_payment = 'complete';
						$user->subscription_type = 'paid';
						$user->is_register_complated = 1;
						$user->user_register_type = config('constant.user_type_premium');
						// $user->profile->status = 'ACTIVE';
						$user->profile->save();
						$user->save();
						// $post->ismade = 1;
						$post->save();
						$status = true;
					}else{
						\Log::error("============ user data not update registerUser() in payment helper ===================");
						$status = false;
					}

					
				} else {

					if ($response->getStatusCode() != 200) {
                    	\Log::error("============200 status code Error pay CRM api call else ===================");
	                    $crmApiFailedArr['messageDetails'] = $response->getBody();
	                    $mailDetails = \App\Helpers\Arr::toObject($crmApiFailedArr);
	                    $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
                    }

					if (session()->has('is_renew')) {
						Session::forget('is_renew');
					}

					if(isset($gateway) && $gateway == 'sepa'){
						return $status;
					}
					return redirect(config('app.locale') . '/');
				}

				if (Session::has('params')) {
					Session::forget('params');
				}
			}
			
			if (session()->has('is_renew')) {
				Session::forget('is_renew');
			}
		}
		return $status;
	}

	/**
	 	* Save the payment
	 	*
	 	* @param $post
	 	* @param $params
	 	* @return PaymentModel
 	*/
	public static function savePayment($post, $params) {
		$accept_method = static::$accept_method;
		$is_webhook_call = static::$is_webhook_call;
		$transaction_status = 'approved';
		// get payment
		$currentPayment = PaymentModel::withoutGlobalScope(StrictActiveScope::class)
				->where('post_id', $post->id)
				->orderBy('created_at', 'DESC')
				->first();
		
		// user already paid redirect home with success message.
		if(!empty($currentPayment) && $currentPayment->transaction_status == 'approved'){
			Session::flush();
			Session::put('already_paid', 'yes');
			flash(t("sign_contract_link"))->success();
			return redirect(config('app.locale').'/'); exit();
		}

		//check if payment method is sepa then redirect to home page
		if (!empty($currentPayment) && ($currentPayment->payment_method_id == 5 || $currentPayment->gateway == 'sepa') && $currentPayment->transaction_status === 'pending') {
			Session::flush();
			Session::put('already_paid', 'yes');
			if($currentPayment->payment_method_id == 5){
				flash(t("offline_payment_selected"))->success();
			}
			else if($currentPayment->gateway == 'sepa'){
				flash(t("your payment request is under processing"))->success();
			}
			return redirect(config('app.locale').'/'); exit();
		}

		// calling function webhook update payment approved.
		if($accept_method == 'sepa' && $is_webhook_call == 1){

			$currentPayment->transaction_status = 'approved';
			$currentPayment->save();
			return $currentPayment;
		}
		
		// sepa payment without webhook call payment status is panding.
		if($accept_method == 'sepa' && $is_webhook_call == 0){
			$transaction_status = 'pending';
		}
		
		// get package
		$package = Package::find($params['package_id']);
		
		$transaction_expiry_date = '';
		$transaction_listing_period = '';
		$transaction_listing_expiry = '';
		$transaction_listings = '';
		$package_price = 0;
		$tax = 0;
		$tax_price = 0;

		if(!empty($package) && $package->count() > 0){
			
			if(!empty($package->duration) && !empty($package->duration_period)){
				$to_date = '+'.$package->duration.' '.$package->duration_period;
				$transaction_expiry_date = date('Y-m-d', strtotime($to_date. "-1 days"));
			}
			
			$transaction_listing_period = $package->duration_period;
			$transaction_listing_expiry = $package->duration;
			$transaction_listings =  $package->package_listings;

			$package_price = !empty($package->price) ? $package->price : 0;
			$tax = !empty($package->tax) ? $package->tax : 0;
			$tax_price = ($package_price * $tax)/100;
			// $tax_price = $params['tax'];
		}
		
		Log::info('Payment params', ['Payment params Array' => $params]);
		// Save the payment
		$paymentInfo = [
			'post_id' => $post->id,
			'package_id' => $params['package_id'],
			'payment_method_id' => $params['payment_method'],
			'transaction_id' => (isset($params['transaction_id'])) ? $params['transaction_id'] : null,
			'transaction_amount' => (isset($params['transaction_amount'])) ? $params['transaction_amount'] : null,
			'transaction_status' => $transaction_status,
			'transaction_expiry_date' => $transaction_expiry_date,
			'transaction_listing_period' => $transaction_listing_period,
			'transaction_listing_expiry' => $transaction_listing_expiry,
			'transaction_listings' => $transaction_listings,
			'packege_price' => $package_price,
			'tax_price' => $tax_price,
			'additional_charges' => (!empty($params['additional_charges'])) ? $params['additional_charges'] : [],
			'gateway' => $accept_method,
		];
		$payment = new PaymentModel($paymentInfo);
		$payment->save();
		return $payment;
	}

	/**
	 	* Save the payment coupon
	 	*
	 	* @param $post
	 	* @param $params
	 	* @return PaymentCoupon
 	*/
	public static function savePaymentCoupon($payment, $params) {

		$accept_method = static::$accept_method;
		$is_webhook_call = static::$is_webhook_call;

		if($accept_method == 'sepa' && $is_webhook_call == 1){ return true; }

		$is_payment_coupon_save_data = 0;
		// save payment coupon
		if($params['is_coupon_applied'] == 1){
			
			$paymentCouponInfo['coupon_code'] = $params['coupon_code'];
			$paymentCouponInfo['coupon_id'] = $params['coupon_id'];
			$paymentCouponInfo['coupon_name'] = $params['coupon_name'];
			$paymentCouponInfo['coupon_discount'] = $params['coupon_discount'];
			$paymentCouponInfo['discounted_amount'] = $params['discount_coupon_amount'];
			$paymentCouponInfo['discount_type'] = $params['discount_type'];
			$paymentCouponInfo['coupon_type'] = $params['coupon_type'];
			$paymentCouponInfo['coupon_tax'] = $params['coupon_tax'];
			$is_payment_coupon_save_data = 1;
		}
		// save payment coupon
		if($params['is_payment_method_coupon_applied'] == 1){
			
			$paymentCouponInfo['payment_coupon_code'] = $params['payment_method_discount_coupon_code'];
			$paymentCouponInfo['payment_coupon_id'] = $params['payment_method_discount_coupon_id_coupon'];
			$paymentCouponInfo['payment_coupon_name'] = $params['payment_method_discount_name'];
			$paymentCouponInfo['payment_coupon_discount'] = $params['payment_method_discount'];
			$paymentCouponInfo['payment_discounted_amount'] = $params['payment_method_discount_amount'];
			$paymentCouponInfo['payment_discount_type'] = $params['payment_method_discount_type'];
			$paymentCouponInfo['payment_coupon_type'] = $params['payment_method_coupon_type'];
			$paymentCouponInfo['payment_coupon_tax'] = $params['payment_method_discount_tax'];
			$is_payment_coupon_save_data = 1;
		}
		// save payment coupon data
		if($is_payment_coupon_save_data == 1){
			$paymentCouponInfo['payment_id'] = $payment->id;
			$paymentCoupon = new PaymentCoupon($paymentCouponInfo);
			$paymentCoupon->save();
		}
		return true;
	}
}
