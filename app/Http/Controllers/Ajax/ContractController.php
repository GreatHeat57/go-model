<?php

namespace App\Http\Controllers\Ajax;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Stripe\Charge;
use Stripe\Event;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Source;
use Stripe\Stripe;
use App\Helpers\Payment as PaymentHelper;
use App\Models\Post;
use App\Models\Payment;

class ContractController extends Controller
{   
    public function webhook() {
        Stripe::setApiKey(config('app.stripe_secret'));

        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        }

        \Log::info('Payment Intent object result inside', ['result' => '====================================']);

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object; // contains a StripePaymentIntent
                $this->storelog($paymentIntent, 'response');
                $this->handlePaymentIntentSucceeded($paymentIntent);
                break;
            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object; // contains a StripePaymentIntent
                $this->storelog($paymentIntent, 'response');
                $this->handlePaymentIntentPaymentFailed($paymentIntent);
                break;
            case 'payment_method.attached':
                $paymentMethod = $event->data->object; // contains a StripePaymentMethod
                $this->handlePaymentMethodAttached($paymentMethod);
                break;
            case 'source.canceled':
                $source = $event->data->object; // contains a StripePaymentIntent
                $this->storelog($source, 'cancel');
                $this->handleSourceCanceled($source);
                break;
            case 'source.chargeable':
                $source = $event->data->object; // contains a StripePaymentIntent
                $this->handleSourceChargeable($source);
                break;
            case 'source.failed':
                $source = $event->data->object; // contains a StripePaymentIntent
                $this->storelog($source, 'response');
                $this->handleSourceFailed($source);
                break;
            case 'charge.succeeded':
                $charge = $event->data->object; // contains a StripePaymentIntent
                $this->storelog($charge, 'response');
                $this->handleChargeSucceeded($charge);
                break;
            case 'charge.failed':
                $charge = $event->data->object; // contains a StripePaymentIntent
                // $this->storelog($charge, 'response');
                $this->handleChargeFailed($charge);
                break;
            case 'charge.pending':
                // \Log::info('sofort charge pending', ['Request Array' => json_encode($event)]);
                // $charge = $event->data->object; // contains a StripePaymentIntent
                // $this->storelog($charge, 'response');
                // $this->handleChargeSucceeded($charge);
                break;
            default:
                // Unexpected event type
                http_response_code(400);
                exit();
        }

        http_response_code(200);

        // $result['result'] = 'success';
        // return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
        
    }

    private function handlePaymentMethodAttached(PaymentMethod $paymentMethod)
    {
        return true;
    }

    // public function handlePaymentIntentSucceeded(Request $request)
    private function handlePaymentIntentSucceeded(PaymentIntent $paymentIntent)
    {

        /*if (in_array('sepa_debit', $paymentIntent->payment_method_types)) {


           // return $status;
            // $payment = $this->register($post, $metadata);
            
            // Save local parameters into session
            // Session::put('params', $localParams);

            // PaymentHelper::paymentConfirmationActions('$params', '$post'); die("here");

        	// $req_arr = array(
        	// 	'action' => 'pay', //required
        	// 	'wpusername' => $paymentIntent->metadata->id ? $paymentIntent->metadata->id : '', // required
        	// 	'transactionid' => $paymentIntent->client_secret,
        	// 	'gateway' => 'sepa_debit',
        	// 	'type' => 'stripecard',
        	// 	'currency' => $paymentIntent->metadata->original_currency,
        	// 	'description' => $paymentIntent->description,
        	// 	'amount' => $paymentIntent->metadata->original_amount,
        	// );
        	// $response = CommonHelper::go_call_request($req_arr);
            // var_dump($req_arr);
        }*/

        return true;
    }

    private function handlePaymentIntentPaymentFailed(PaymentIntent $paymentIntent)
    {

        return true;
    }

    private function handleSourceChargeable(Source $sourceObj)
    {
        // Stripe::setApiKey(config('app.stripe_secret'));
        // $charge = Charge::create([
        //     'amount' => $sourceObj->amount,
        //     'currency' => $sourceObj->currency,
        //     'source' => $sourceObj->id,
        // ]);
        return true;
    }

    private function handleSourceCanceled(Source $sourceObj)
    {

    }

    private function handleSourceFailed(Source $sourceObj)
    {

    }

    private function handleChargeSucceeded(Charge $chargeObj)
    {
        switch ($chargeObj->payment_method_details->type) {
            case 'card':
                break;
            case 'eps':
                break;
            case 'giropay':
                break;
            case 'sofort':
                /*$req_arr = array(
                    'action' => 'pay', //required
                    'wpusername' => $chargeObj->metadata->id ? $chargeObj->metadata->id : '', // required
                    'transactionid' => $chargeObj->source->client_secret,
                    'gateway' => 'sepa_debit',
                    'type' => 'stripecard',
                    'currency' => $chargeObj->metadata->original_currency,
                    'description' => $chargeObj->description,
                    'amount' => $chargeObj->metadata->original_amount,
                );
                $response = CommonHelper::go_call_request($req_arr);*/
                break;
            case 'sepa_debit':
                \Log::error("============here in handleChargeSucceeded Sepa debit===================");
                $metadata = $chargeObj->metadata;
                $params = [
                    'payment_method' => isset($metadata->payment_method) ? $metadata->payment_method : '',
                    'accept_method' => isset($metadata->accept_method) ? $metadata->accept_method : '',
                    'is_webhook_call' => 1,
                    'is_renew' => isset($metadata->is_renew) ? $metadata->is_renew : '',
                    'currency' => isset($chargeObj->currency) ? strtoupper($chargeObj->currency) : '',
                    'description' => isset($chargeObj->description) ? $chargeObj->description : '',
                    'amount' => isset($metadata->original_amount) ? $metadata->original_amount : '',
                    'post_id' => isset($metadata->post_id) ? $metadata->post_id : '',
                ];
                // Get the entry
                $post = Post::withoutGlobalScopes()->where('id', $metadata->post_id)->first();
                $status = PaymentHelper::paymentConfirmationActions($params, $post);
            break;
            default:
                # code...
                break;
        }
    }

    private function handleChargeFailed(Charge $chargeObj)
    {
        switch ($chargeObj->payment_method_details->type) {
            case 'card': break;
            case 'eps': break;
            case 'giropay': break;
            case 'sofort':
                
                // \Log::info('sofort handleChargeFailed chargeObj', ['response Array' => $chargeObj]);
                \Log::error("============here in handleChargeFailed ===================");
                $username = isset($chargeObj->metadata->id) ? $chargeObj->metadata->id : '';
                $transactionid = isset($chargeObj->metadata->post_id) ? $chargeObj->metadata->post_id : '';
                \Log::info('sofort handleChargeFailed username', ['username' => $username]);
                if(!empty($username)){ 
                    
                    $req_arr = array(
                        'action' => 'payment_failed', //required
                        'wpusername' => $username, // required
                        'transactionid' => $transactionid,
                        'payment_response' => json_encode($chargeObj),
                    );
                    try{
                        $response = CommonHelper::go_call_request($req_arr);
                        if ($response->getStatusCode() != 200) {
                            $body = $response->getBody();
                            throw new \Exception($body);
                        }
                    }catch(\Exception $e){
                        \Log::error("============ Error payment failed CRM api call ===================");
                        $paymentFailedArr = [
                            'gocode' => isset($chargeObj->metadata->user_id) ? $chargeObj->metadata->user_id : '',
                            'username' => $username,
                            'subject' => t('Payment process error'),
                            'email' => isset($chargeObj->metadata->email) ? $chargeObj->metadata->email : '',
                            'message' => t('Some error occurred while processing sofort faild payment in webhook'),
                            'payment_method' => isset($chargeObj->payment_method_details->type) ? $chargeObj->payment_method_details->type : '',
                            'messageDetails' => $e->getMessage(),
                        ];
                        $mailDetails = \App\Helpers\Arr::toObject($paymentFailedArr);
                        $sendEmail = CommonHelper::crmApiCallFailedErrorMailToAdmin($mailDetails);
                    }
                }
                // $payment = Payment::where('client_secret', $chargeObj->source->client_secret)->first();
                // $payment->status = $chargeObj->status;
                // $payment->save();

                // $source = Source::where('source_id', $chargeObj->source->id)->first();
                // $source->status = $chargeObj->source->status;
                // $source->save();
                break;
            case 'sepa_debit':
                \Log::error("============here in handleChargeFailed ===================");
                $post_id = isset($chargeObj->metadata->post_id) ? $chargeObj->metadata->post_id : '';
                //fetch post_id using payment
                $currentPayment = Payment::withoutGlobalScope(StrictActiveScope::class)->where('post_id', $post_id)->orderBy('id', 'DESC')->first();
                if(!empty($currentPayment)){
                    $currentPayment->transaction_status = 'cancelled';
                    $currentPayment->save();
                }
            break;

            default:
                # code...
                break;
        }

    }

    private function storelog($paymentIntent, $logtype){

        $email = $post_id = $payment_method = $accept_method = $rawData = "";

        if(isset($paymentIntent) && !empty($paymentIntent) && isset($paymentIntent->metadata) && !empty($paymentIntent->metadata)){
            
            $metadata = $paymentIntent->metadata;

            $payment_method = isset($metadata['payment_method'])? $metadata['payment_method'] : '';
            $accept_method = isset($metadata['payment_sub_method'])? $metadata['payment_sub_method'] : '';

            $source_payment_method = isset($metadata->source['payment_method'])? $metadata->source['payment_method'] : '';
            $source_accept_method = isset($metadata->source['payment_sub_method'])? $metadata->source['payment_sub_method'] : '';

            $email = isset($metadata['email'])? $metadata['email'] : '';
            $post_id = isset($metadata['post_id'])? $metadata['post_id'] : '';
            $payment_method = ($payment_method != "")? $payment_method : $source_payment_method;
            $accept_method = ($accept_method != "")? $accept_method : $source_accept_method;
            $rawData = $paymentIntent;
        }

        //store the payment response data
        try{
            PaymentHelper::logResponse($email, $post_id, $payment_method, $accept_method, $paymentIntent, $logtype);
        }catch(\Exception $e){
            \Log::info(' Error while store payment response', ['error' => $e->getMessage()]);
        }
    }

    /*
    **
     * Save the payment and Send payment confirmation email
     *
     * @param $post
     * @param $params
     * @return PaymentModel
     */
    // public static function register(Post $post, $params) {
    //     if (empty($post)) {
    //         return null;
    //     }
    //     // Update ad 'reviewed'
    //     $post->reviewed = 1;
    //     $post->featured = 1;
    //     $post->save();
        
    //     $package = Package::find($params->package_id);
        
    //     $transaction_expiry_date = '';
    //     $transaction_listing_period = '';
    //     $transaction_listing_expiry = '';
    //     $transaction_listings = '';
    //     $package_price = 0;
    //     $tax = 0;
    //     $tax_price = 0;
    //     if(!empty($package) && $package->count() > 0){
            
    //         if(!empty($package->duration) && !empty($package->duration_period)){
    //             $to_date = '+'.$package->duration.' '.$package->duration_period;
    //             $transaction_expiry_date = date('Y-m-d', strtotime($to_date. "-1 days"));
    //         }
            
    //         $transaction_listing_period = $package->duration_period;
    //         $transaction_listing_expiry = $package->duration;
    //         $transaction_listings =  $package->package_listings;

    //         $package_price = !empty($package->price) ? $package->price : 0;
    //         $tax = !empty($package->tax) ? $package->tax : 0;
    //         $tax_price = ($package_price * $tax)/100;
    //         // $tax_price = $params['tax'];
    //     }
        
    //     // \Log::info('Payment params', ['Payment params Array' => $params]);
    //     // Save the payment
    //     $paymentInfo = [
    //         'post_id' => $post->id,
    //         'package_id' => $params->package_id,
    //         'payment_method_id' => $params->payment_method,
    //         'transaction_id' => (isset($params->transaction_id)) ? $params->transaction_id : null,
    //         'transaction_amount' => (isset($params->transaction_amount)) ? $params->transaction_amount : null,
    //         'transaction_status' => 'approved',
    //         'transaction_expiry_date' => $transaction_expiry_date,
    //         'transaction_listing_period' => $transaction_listing_period,
    //         'transaction_listing_expiry' => $transaction_listing_expiry,
    //         'transaction_listings' => $transaction_listings,
    //         'packege_price' => $package_price,
    //         'tax_price' => $tax_price,
    //         'additional_charges' => (isset($params->additional_charges)) ? $params->additional_charges : [], 
    //     ];
        
    //     $payment = new Payment($paymentInfo);
    //     $payment->save();

    //     $is_payment_coupon_save_data = 0;
    //     // save payment coupon
    //     if($params->is_coupon_applied == 1){
            
    //         $paymentCouponInfo['coupon_code'] = $params->coupon_code;
    //         $paymentCouponInfo['coupon_id'] = $params->coupon_id_coupon;
    //         $paymentCouponInfo['coupon_name'] = $params->coupon_name;
    //         $paymentCouponInfo['coupon_discount'] = $params->coupon_discount;
    //         $paymentCouponInfo['discounted_amount'] = $params->discount_coupon_amount;
    //         $paymentCouponInfo['discount_type'] = $params->discount_type;
    //         $is_payment_coupon_save_data = 1;
    //     }

    //     // save payment coupon
    //     if($params->is_payment_method_coupon_applied == 1){
            
    //         $paymentCouponInfo['payment_coupon_code'] = $params->payment_method_coupon_code;
    //         $paymentCouponInfo['payment_coupon_id'] = $params->payment_method_coupon_id_coupon;
    //         $paymentCouponInfo['payment_coupon_name'] = $params->payment_method_coupon_name;
    //         $paymentCouponInfo['payment_coupon_discount'] = $params->payment_method_discount;
    //         $paymentCouponInfo['payment_discounted_amount'] = $params->payment_method_coupon_amount;
    //         $paymentCouponInfo['payment_discount_type'] = $params->payment_method_discount_type;
    //         $is_payment_coupon_save_data = 1;
    //     }

    //     // save payment coupon data
    //     if($is_payment_coupon_save_data == 1){
    //         $paymentCouponInfo['payment_id'] = $payment->id;
    //         $paymentCoupon = new PaymentCoupon($paymentCouponInfo);
    //         $paymentCoupon->save();
    //     }

    //     if(!empty($post->user_id) && !empty($transaction_expiry_date)){
    //         $user = User::where('id', $post->user_id)->update(['contract_expire_on' => $transaction_expiry_date]);
    //     }
        
    //     // SEND EMAILS

    //     // Get all admin users
    //     $admins = User::where('is_admin', 1)->get();

    //     // Send Payment Email Notifications
    //     if (config('settings.mail.payment_email_notification') == 1) { 
    //         // Send to Admin the Payment Notification Email
    //         try {

    //             if ($admins->count() > 0) {
    //                 foreach ($admins as $admin) {

    //                     Mail::send(new PaymentNotification($payment, $post, $admin));
    //                 }
    //             }
    //         } catch (\Exception $e) {
    //             flash($e->getMessage())->error();
    //         }
    //     }

    //     // after successfull payment, register user and generate password
    //     try {
    //         self::registerUser($post, $params);
    //     }catch (\Exception $e) {
    //         flash($e->getMessage())->error();
    //     }

    //     return true;
    //     // return $payment;
    // }


    // active user and generate the password after sucessfull payment completed
    // public static function registerUser($post, $params){
    //     \Log::error("============here in registerUser ContractController Ajax===================");
    //     $is_renew = false;
    //     $is_update_user_data = false;

    //     // disable to get is_renew param from the session and pass it in payment form post
    //     if(isset($params->is_renew) && $params->is_renew == 1){
    //         \Log::info('get renew flag in the request param', ['is_renew' => $params->is_renew]);
    //         $is_update_user_data = true;
    //         $is_renew = true;
    //     }

    //     $username = '';
    //     if (isset($params) && !empty($params)) {    
    //         $paymentMethods = PaymentMethodModel::find($params->payment_method);
    //         $user = isset($post->user)? $post->user : '';
    //         $username = ($user->username) ? $user->username : '';
    //         $coupon_data = array();
    //         // save payment coupon
    //         if($params->is_coupon_applied == 1){
                
    //             $coupon_data[0] = array ( 
    //                                 'coupon_amount'     =>  $params->coupon_amount,
    //                                 'coupon_tax'        =>  $params->coupon_tax,
    //                                 'coupon_name'       =>  $params->coupon_name,
    //                                 'coupon_id_coupon'  =>  $params->coupon_id_coupon,
    //                                 'coupon_code'       =>  $params->coupon_code,
    //                                 'coupon_type'       =>  $params->coupon_type,
    //                                 );
    //         }

    //         // save payment coupon
    //         if($params->is_payment_method_coupon_applied == 1){
    //             $coupon_data[1] = array ( 
    //                                     'coupon_amount'     => $params->payment_method_coupon_amount,
    //                                     'coupon_tax'        => $params->payment_method_coupon_tax,
    //                                     'coupon_name'       => $params->payment_method_coupon_name,
    //                                     'coupon_id_coupon'  => $params->payment_method_coupon_id_coupon,
    //                                     'coupon_code'       => $params->payment_method_coupon_code,
    //                                     'coupon_type'       => $params->payment_method_coupon_type,
    //                                     );
    //         }
            
    //         if(count($coupon_data) > 0){
    //             $coupon_data = json_encode($coupon_data);
    //         }
            
    //         $req_arr = array(
    //             'action' => 'pay', //required
    //             'wpusername' => ($user->username) ? $user->username : '', // required
    //             'transactionid' => $params->transaction_id,
    //             'gateway' => $paymentMethods->name,
    //             'type' => $params->accept_method,
    //             'currency' => $params->currency,
    //             'description' => $params->description,
    //             'amount' => $params->transaction_amount,
    //             'coupon_data' => $coupon_data,
    //             'country_code' => ($user->country_code) ? strtoupper($user->country_code) : '',
    //         );
            
    //         $response = CommonHelper::go_call_request($req_arr);
    //         \Log::info('Request Array pay finish', ['Request Array' => $req_arr]);

    //         $json = json_decode($response->getBody());
    //         \Log::info('Response Array pay finish', ['Response Array' => $json]);
    //         \Log::info('Response Array staus code finish', ['Response Array staus code' => $response->getStatusCode()]);
                
    //         \Log::info('is renew', ['Request Array' => $is_renew]);

    //         if ($response->getStatusCode() == 200) {

    //             if($is_renew == false){

    //                 $req_arr = array(
    //                     'action' => 'generate_pw', //required
    //                     'wpusername' => $user->username, // required
    //                     'sendmail' => (!in_array($user->provider, ['google','facebook']))? true : false
    //                 );

    //                 $response = CommonHelper::go_call_request($req_arr);
    //                 \Log::info('Request Array generate_pw', ['Request Array' => $req_arr]);

    //                 $json = json_decode($response->getBody());
    //                 \Log::info('Response Array generate_pw', ['Response Array' => $json]);

    //                 if ($response->getStatusCode() == 200) {

    //                     $body = (string) $response->getBody();
    //                     \Log::info('Response Array password', ['Response password' => $body]);


    //                     if(!in_array($user->provider, ['google','facebook'])){
    //                         $user->password = bcrypt($body);
    //                     }

    //                     $req_arr_one = array(
    //                         'action' => 'activate', //required
    //                         'wpusername' => ($user->username) ? $user->username : '', // required
    //                     );

    //                     $res = CommonHelper::go_call_request($req_arr_one);
    //                     \Log::info('Request Array activate finish', ['Request Array' => $req_arr_one]);

    //                     $json = json_decode($response->getBody());
    //                     \Log::info('Response Array activate finish', ['Response Array' => $json]);

    //                     if ($res->getStatusCode() == 200) {

    //                         $is_update_user_data = true;
    //                     }
    //                 }
    //             }

    //             if($is_update_user_data == true){

    //                 $user->active = 1;
    //                 $user->subscribed_payment = 'complete';
    //                 $user->subscription_type = 'paid';
    //                 $user->is_register_complated = 1;
    //                 $user->profile->status = 'ACTIVE';
    //                 $user->profile->save();
    //                 $user->save();
    //                 $post->ismade = 1;
    //                 $post->save();
    //             }
    //         } else {
    //             if (session()->has('is_renew')) {
    //                 Session::forget('is_renew');
    //             }
    //             // return redirect(config('app.locale') . '/');
    //         }

    //         if (Session::has('params')) {
    //             Session::forget('params');
    //         }
             
    //         if (session()->has('is_renew')) {
    //             Session::forget('is_renew');
    //         }
    //     }
    //     return true;
    // }
}