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

namespace App\Http\Controllers\Auth\Traits;

use App\Helpers\CommonHelper;
use App\Helpers\Localization\Language;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

trait VerificationTrait {
	use EmailVerificationTrait, PhoneVerificationTrait, RecognizedUserActionsTrait;

	public $entitiesRefs = [
		'user' => [
			'slug' => 'user',
			'namespace' => '\\App\Models\User',
			'name' => 'name',
			'scopes' => [
				\App\Models\Scopes\VerifiedScope::class,
			],
		],
		'post' => [
			'slug' => 'post',
			'namespace' => '\\App\Models\Post',
			'name' => 'contact_name',
			'scopes' => [
				\App\Models\Scopes\VerifiedScope::class,
				\App\Models\Scopes\ReviewedScope::class,
			],
		],
	];

	/**
	 * URL: Verify User's Email Address or Phone Number
	 *
	 * @param $field
	 * @param null $token
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */

	public function verification($field, $token = null)
	{	
		// Keep Success Message If exists
		if (session()->has('message')) {
			session()->keep(['message']);
		}

		// Get Entity
		$entityRef = $this->getEntityRef(getSegment(2));
		if (empty($entityRef)) {
			abort(404, t("Entity ID not found"));
		}

		// Get Field Label
		$fieldLabel = t('Email Address');
		if ($field == 'phone') {
			$fieldLabel = t('Phone Number');
		}

		// Show Token Form
		if (empty($token) && !Request::filled('_token')) {
			return view('token');
		}

		// Token Form Submission
		if (Request::filled('_token')) {
			// Form validation
			$validator = Validator::make(Request::all(), ['code' => 'required']);
			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			if (Request::filled('code')) {
				return redirect(config('app.locale') . '/verify/' . $entityRef['slug'] . '/' . $field . '/' . Request::input('code'));
			}
		}

		// Get Entity by Token
		$model = $entityRef['namespace'];
		$entity = $model::withoutGlobalScopes($entityRef['scopes'])->where($field . '_token', $token)->first();

		if (!empty($entity)) {

			// check verification link is expired or not
			$entity->preventAttrSet = true;

			$link_create_time= new \DateTime($entity->created_at); 
			$current_time= new \DateTime();

			$interval= $link_create_time->diff($current_time);
			$total_hours = ($interval->days * 24) + $interval->h;




			// check user is not active, email is not verify and also check link is not grater than 48 hr
			// If created link time more then 48 hours then its expired and update is_verification_expired = 1
			if($entity->active != 1 && $entity->{'verified_' . $field} != 1 && $total_hours > 48){

				flash(t("Your verification link has expired"))->error();
				$message = t("Resend the verification message to verify your email address");
				$message .= ' <a href="' . lurl('verify/user/'. $entity->id . '/resend/email') . '" class="btn btn-warning">' . t("Re-send") . '</a>';
				
				flash($message)->warning();

				return redirect(config('app.locale'));
			}


			// check if user is active and email is verify
			if($entity->{'verified_' . $field} == 1 && $entity->active == 1 && $entity->password != ""){

				flash(t("active_and_verify_user"))->success();
				return redirect(config('app.locale'));

			// check email is verify and user is not active and if active then check the password is generated or not.
			}else if($entity->{'verified_' . $field} == 1 && ( $entity->active == 0 || ($entity->active == 1 &&  $entity->password == "") ) ){


				// check contract link is empty and also user type is also emtpy then redirect register data page for social page
				if( isset($entity->profile) && empty($entity->profile->contract_link) && empty($entity->user_type_id)){
					$message = t("Your :field is already verified", ['field' => $fieldLabel]);
					flash($message)->success();
					$redirect_url = config('app.locale') . '/' . trans('routes.registerData') . '/' . $entity->hash_code;
					return redirect($redirect_url);
				}

				// check profile is set and contract link also set but register flow is not complted is_register_complated = false then redirect to completed the flow
				
				if( isset($entity->profile) && !empty($entity->profile->contract_link) && $entity->is_register_complated == 0 ){
					$message = t("Your :field is already verified", ['field' => $fieldLabel]);
					flash($message)->success();
					$redirect_url = config('app.locale') . '/' . trans('routes.registerData') . '/' . $entity->hash_code;
					return redirect($redirect_url);
				}


				// check user is not active but contract link is generated then show message to complete contract process
				if(isset($entity->profile) && $entity->active == 0 && !empty($entity->profile->contract_link)){
					// flash(t("Your :field is already verified", ['field' => $fieldLabel]))->success();
					// flash(t("please_sign_contract_to_active_account"))->error();
					flash(t("Register thans page content"))->success();
					return redirect(config('app.locale') . '/');
				}

				// check user is active and contract link is generated then show message to complete contract process
				if(isset($entity->profile) && $entity->active == 1 && empty($entity->password) && !empty($entity->profile->contract_link)){
					flash(t("Your :field is already verified", ['field' => $fieldLabel]))->success();
					return redirect(config('app.locale') . '/');
				}

			}


			if ($entity->{'verified_' . $field} != 1) {
				// Verified
				$entity->{'verified_' . $field} = 1;
				$entity->save();

				$message = t("Congratulation :name ! Your :field has been verified", ['name' => $entity->{$entityRef['name']}, 'field' => $fieldLabel]);
				flash($message)->success();

				// Remove Notification Trigger
				if (session()->has('emailOrPhoneChanged')) {
					session()->forget('emailOrPhoneChanged');
				}
				if (session()->has('verificationEmailSent')) {
					session()->forget('verificationEmailSent');
				}
				if (session()->has('verificationSmsSent')) {
					session()->forget('verificationSmsSent');
				}
			} else {
				$message = t("Your :field is already verified", ['field' => $fieldLabel]);
				flash($message)->success();
			}

			// Get Next URL
			// Get Default next URL
			$nextUrl = config('app.locale') . '/?from=verification';

			// Is User Entity
			if ($entityRef['slug'] == 'user') {
				// Match User's ads (posted as Guest)
				$this->findAndMatchPostsToUser($entity);

				// Get User creation next URL
				// Login the User
				// if (Auth::loginUsingId($entity->id)) {
				// 	$nextUrl = config('app.locale') . '/account';
				// } else {
				// 	if (session()->has('userNextUrl')) {
				// 		$nextUrl = session('userNextUrl');
				// 	} else {
				// 		$nextUrl = config('app.locale') . '/' . trans('routes.login');
				// 	}
				// }

				// Send 'lead_create' action to CRM
				// $country = config('country.code');
				// $language = new Language;
				// $language = $language->find();
				// $lang = $language['name'];
				// $lang = strtolower($lang);

				// $req_arr = array(
				// 	'action' => 'lead_create',
				// 	'wpusername' => $entity->email,
				// 	'locale' => config('app.locale'),
				// 	'country' => $country,
				// 	'verification_link' => url(config('app.locale').'/verify/' . $entityRef['slug'] . '/email/' . $entity->email_token)
				// );

				// $response = CommonHelper::go_call_request($req_arr);
				// Log::info('Request Array', ['Request Array lead_create' => $req_arr]);

				// $json = json_decode($response->getBody());
				// Log::info('Response Array', ['Request Array lead_create' => $json]);
				
				// if ($response->getStatusCode() == 200) {
				// 	$timestamp = time();

				// 	$hash_code = $this->getHashCode();

				// 	if(empty($entity->hash_code)){
				// 		$entity->hash_code = $hash_code;
				// 		$entity->save();
				// 	} else {
				// 		$hash_code = $entity->hash_code;
				// 	}

				// 	$nextUrl = config('app.locale') . '/' . trans('routes.registerData') . '/' . $hash_code;
				// } else {
				// 	echo "Try again";
				// }

				$req_arr = array(
					'action' => 'lead_verified',
					'verification_link' => config('app.url').'/'.config('app.locale').'/verify/'.$entityRef['slug'].'/email/'.$entity->email_token
				);

				$response = CommonHelper::go_call_request($req_arr);
				Log::info('Request Array', ['Request Array lead_verified' => $req_arr]);

				$json = json_decode($response->getBody());
				Log::info('Response Array', ['Response Array lead_verified' => $json]);

				if ($response->getStatusCode() == 200) {
					
					$timestamp = time();

					$hash_code = $this->getHashCode();

					if(empty($entity->hash_code)){
						$entity->hash_code = $hash_code;
						$entity->save();
					} else {
						$hash_code = $entity->hash_code;
					}

					$nextUrl = config('app.locale') . '/' . trans('routes.registerData') . '/' . $hash_code;
				} else {
					echo "Try again";
				}
			}



			// Is Post Entity
			if ($entityRef['slug'] == 'post') {
				// Match User's Posts (posted as Guest) & User's data (if missed)
				$this->findAndMatchUserToPost($entity);

				// Get Post creation next URL
				if (session()->has('itemNextUrl')) {
					$nextUrl = session('itemNextUrl');
					if (Str::contains($nextUrl, 'create') && !session()->has('tmpPostId')) {
						$nextUrl = config('app.locale') . '/' . $entity->uri . '?preview=1';
					}
				} else {
					$nextUrl = config('app.locale') . '/' . $entity->uri . '?preview=1';
				}
			}

			// Remove Next URL session
			if (session()->has('userNextUrl')) {
				session()->forget('userNextUrl');
			}
			if (session()->has('itemNextUrl')) {
				session()->forget('itemNextUrl');
			}

			// Redirection
			return redirect($nextUrl);
		} else {

			// $message = t("Your :field verification has failed", ['field' => $fieldLabel]);
			$message = t('Sorry, Unable to identify you Please contact administrator');
			flash($message)->error();
			return redirect(config('app.locale') . '/');
			// return view('token');
		}
	}

	/**
	 * @param null $entityRefId
	 * @return null
	 */
	public function getEntityRef($entityRefId = null) {
		if (empty($entityRefId)) {
			if (
				Str::contains(Route::currentRouteAction(), 'Auth\RegisterController') ||
				Str::contains(Route::currentRouteAction(), 'Account\EditController') ||
				Str::contains(Route::currentRouteAction(), 'Admin\UserController') ||
				Str::contains(Route::currentRouteAction(), 'Api\ApiController')
			) {
				$entityRefId = 'user';
			}

			if (
				Str::contains(Route::currentRouteAction(), 'Post\CreateController') ||
				Str::contains(Route::currentRouteAction(), 'Post\EditController') ||
				Str::contains(Route::currentRouteAction(), 'Admin\PostController')
			) {
				$entityRefId = 'post';
			}
		}

		// Check if Entity exists
		if (!isset($this->entitiesRefs[$entityRefId])) {
			return null;
		}

		// Get Entity
		$entityRef = $this->entitiesRefs[$entityRefId];

		return $entityRef;
	}


	//function to create unique crypto code for hash code
	public function crypto_rand_secure($min, $max)
	{
	    $range = $max - $min;
	    if ($range < 1) return $min; // not so random...
	    $log = ceil(log($range, 2));
	    $bytes = (int) ($log / 8) + 1; // length in bytes
	    $bits = (int) $log + 1; // length in bits
	    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
	    do {
	        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
	        $rnd = $rnd & $filter; // discard irrelevant bits
	    } while ($rnd > $range);
	    return $min + $rnd;
	}

	public function getHashCode($length = 32)
	{
	    $token = "";
	    $codeAlphabet = "abcdef";
	    $codeAlphabet.= "0123456789";
	    $max = strlen($codeAlphabet); // edited

	    for ($i=0; $i < $length; $i++) {
	        $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
	    }

	    return $token;
	}
}
