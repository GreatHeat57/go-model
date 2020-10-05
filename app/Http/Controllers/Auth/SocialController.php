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

namespace App\Http\Controllers\Auth;

use App\Helpers\Ip;
use App\Http\Controllers\FrontController;
use App\Mail\UserNotification;
use App\Models\Post;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\VerifiedScope;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Helpers\Localization\Language;
use App\Helpers\CommonHelper;
use Illuminate\Support\Str;

class SocialController extends FrontController
{
    use AuthenticatesUsers;
	
	// If not logged in redirect to
	protected $loginPath = 'login';
	
	// After you've logged in redirect to
	protected $redirectTo = 'account';
	
	// Supported Providers
	private $network = ['facebook', 'google', 'twitter'];
    
    /**
     * SocialController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        // $page_terms = $page_termsclient = array();
        // if(isset($this->pages) && !empty($this->pages) && $this->pages->count() > 0){
        //     foreach($this->pages as $page){
        //         if($page->type == "terms"){
        //             $page_terms = $page;
        //         }elseif($page->type == "termsclient") {
        //             $page_termsclient = $page;
        //         }
        //     }
        // }
        // view()->share('page_terms', $page_terms);
        // view()->share('page_termsclient', $page_termsclient);

        // From Laravel 5.3.4 or above
        $this->middleware(function ($request, $next) {
            // get terms and conditions for country code wise
            $this->getTermsConditions();

            return $next($request);
        });
	
		// Set default URLs
		//$isFromLoginPage = Str::contains(url()->previous(), '/' . trans('routes.login'));

		$this->loginPath = config('app.locale') . '/' . trans('routes.login');
		$this->redirectTo = config('app.locale') . '/';
    }
    
    /**
     * Redirect the user to the Provider authentication page.
     *
     * @return mixed
     */
    public function redirectToProvider()
    {
		// Get the Provider and verify that if it's supported
		$provider = getSegment(2);
        if (!in_array($provider, $this->network)) {
            abort(404);
        }
	
		// If previous page is not the Login page...
		if (!Str::contains(url()->previous(), trans('routes.login'))) {
			// Save the previous URL to retrieve it after success or failed login.
			session()->put('url.intended', url()->previous());
		}
	
		// Redirect to the Provider's website
        return Socialite::driver($provider)->redirect();
    }
    
    /**
     * Obtain the user information from Provider.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback()
    {
        // assign global varibale value to check social redirect error url
        $req = $_GET;

		// Get the Provider and verify that if it's supported
		$provider = getSegment(2);
        if (!in_array($provider, $this->network)) {
            abort(404);
        }
	
		// Check and retrieve previous URL to show the login error on it.
		if (session()->has('url.intended')) {
			$this->loginPath = session()->get('url.intended');
		}

        
        // check user reject to login than handle the error code
        if( isset($req) && isset($req['error']) && $req['error'] === 'access_denied'){
             flash(t("user_denied"))->error();
            return redirect(config('app.locale') . '/');
        }
	   
		// Get the Country Code
		$countryCode = config('country.code', config('ipCountry.code'));
        
        // API CALL - GET USER FROM PROVIDER
        try {
            $userData = Socialite::driver($provider)->user();

            // Data not found
            if (!$userData) {
                $message = t("Unknown error, Please try again in a few minutes");
                flash($message)->error();
                
                return redirect($this->loginPath);
            }
            
            // Email not found if google provider
            if ($provider == 'google') {
                if (!$userData || !filter_var($userData->getEmail(), FILTER_VALIDATE_EMAIL)) {
                    $message = t("Email address not found, You can\'t use your :provider account on our website", ['provider' => ucfirst($provider)]);
                    flash($message)->error();
                    
                    return redirect($this->loginPath);
                }
            }

        } catch (\Exception $e) {
            $message = $e->getMessage();

            if (is_string($message) && !empty($message)) {
                flash($message)->error();
            } else {
                $message = "Unknown error. The social network API doesn't work.";
                flash($message)->error();
            }
            
            return redirect($this->loginPath);
        }

        // Debug
        // dd($userData);
        
        // DATA MAPPING
        try {
            $mapUser = [];
            if ($provider == 'facebook') {

                $mapUser['name'] = (isset($userData->name)) ? $userData->name : '';
                $user_name_arr = (isset($mapUser['name']))? explode(' ', $mapUser['name']) : '';
                
                // if ($mapUser['name'] == '') {
                //     if (isset($userData->user['first_name']) && isset($userData->user['last_name'])) {
                //         $mapUser['name'] = $userData->user['first_name'] . ' ' . $userData->user['last_name'];
                //     }
                // }

            } else {
                if ($provider == 'google') {
                    $mapUser['name'] = (isset($userData->name)) ? $userData->name : '';
                    $user_name_arr = (isset($mapUser['name']))? explode(' ', $mapUser['name']) : '';
                }
            }

            // GET LOCAL USER
            $user = User::withoutGlobalScopes()->where('provider', $provider)->where('provider_id', $userData->getId())->first();

            // CREATE LOCAL USER IF DON'T EXISTS
            if (empty($user)) {

                $userObj = array();

                if($userData->getEmail() && !empty($userData->getEmail())){
                    // Before... Check if user has not signup with an email
                    $userObj = User::withoutGlobalScopes([VerifiedScope::class])->where('email', $userData->getEmail())->first();
                }


                if (empty($userObj)) {
                    
                    $userInfo = [
                        'country_code'   => $countryCode,
                        'name'           => $mapUser['name'],
                        'email'          => $userData->getEmail(),
                        'ip_addr'        => Ip::get(),
                        'verified_email' => 0,
                        'verified_phone' => 1,
                        'active'         => 0,
                        'provider'       => $provider,
                        'provider_id'    => $userData->getId(),
                        'created_at'     => date('Y-m-d H:i:s'),
                        'hash_code'      => md5(microtime() . mt_rand()),
                    ];

                    /*$country = $countryCode;
                    $language = new Language;
                    $language = $language->find();
                    $lang = $language['name'];
                    $lang = strtolower($lang);
                    
                    $req_arr = array(
                        'action'        => 'lead_create',
                        'wpusername'    =>  $request->input('email'),
                        'lang'       =>  $lang,
                        'country'       =>  $country
                    );*/
            
                    //$response = CommonHelper::go_call_request($req_arr);
                    //if($response->getStatusCode() == 200){
                    try {
                        
                        $user = new User($userInfo);
                        $user->save();

                        $first_name = $last_name = "";
                        
                        if(isset($user_name_arr) && !empty($user_name_arr)){
                            $first_name = isset($user_name_arr[0])? $user_name_arr[0] : '';
                            $last_name = isset($user_name_arr[1])? $user_name_arr[1] : '';
                        }
                    

                        $profileInfo = array(
                            'user_id'	=> $user->id,
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                        );

                        $profile = new UserProfile($profileInfo);
                        $profile->save();

                    } catch (\Exception $e) {

                        flash($e->getMessage())->error();
                        return redirect($this->loginPath);
                    }

                    //}
                    // Update Ads created by this email
                    /*if (isset($user->id) && $user->id > 0) {
                        Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('email', $userInfo['email'])->update(['user_id' => $user->id]);
                    }*/
                    
                    // Send Admin Notification Email
                    // if (config('settings.mail.admin_email_notification') == 1) {
                    //     try {
                    //         // Get all admin users
                    //         $admins = User::where('is_admin', 1)->get();
                    //         if ($admins->count() > 0) {
                    //             foreach ($admins as $admin) {
                    //                 Mail::send(new UserNotification($user, $admin));
                    //             }
                    //         }
                    //     } catch (\Exception $e) {
                    //         flash($e->getMessage())->error();
                    //     }
                    // }

                    return redirect(config('app.locale') . '/' . trans('routes.socialRedirect'). '/' .$userInfo['hash_code']);
                    
                } else {
					// Update 'created_at' if empty (for time ago module)
					// if (empty($userObj->created_at)) {
					// 	$userObj->created_at = date('Y-m-d H:i:s');
					// }
					// $userObj->verified_email = 1;
					// $userObj->verified_phone = 1;
					// $userObj->save();

                    $message = t("email_already_exist_social");
                    flash($message)->error();
                    return redirect(config('app.locale') . '/' . trans('routes.login'));
                }
            }

            if(isset($user) && $user->user_type_id == ""){
                return redirect(config('app.locale') . '/' . trans('routes.socialRedirect'). '/' .$user->hash_code);
            }
            
            //check user is exist and is not active then redirect to register data page
            if(isset($user) && $user->active != 1){

                //check user email is verified or not
                if($user->verified_email == 0){
                    $message = t("Your email address is not verified");
                    flash($message)->error();
                    return redirect($this->loginPath);
                }

                 //check user contract link not set and not active then rediret to register data page.
                if(isset($user->profile) &&  $user->profile->contract_link == "" && $user->active == 0 ){
                    
                    $message = t("You need to complete the registration process");
                    flash($message)->error();

                    if($user->hash_code !== ""){
                        $this->loginPath = config('app.locale') . '/' . trans('routes.registerData') . '/' . $user->hash_code;
                        return redirect($this->loginPath);
                    }
                }

                //check user contract link is set but not completed register process then rediret to register data page.
                if(isset($user->profile) &&  $user->profile->contract_link !== "" && $user->is_register_complated == 0 ){
                    
                    $message = t("You need to complete the registration process");
                    flash($message)->error();

                    if($user->hash_code !== ""){
                        $this->loginPath = config('app.locale') . '/' . trans('routes.registerData') . '/' . $user->hash_code;
                        return redirect($this->loginPath);
                    }
                }

                 //check user have contract link and is not active then rediret back
                if(isset($user->profile) &&  $user->profile->contract_link !== "" && $user->active == 0){
                    $message = t("You do not have signed the contract, Please contact administrators");
                    flash($message)->error();
                    return redirect($this->loginPath);
                }

            }else{
                
                //check user is not blocked by admin
                if( $user->blocked == 1 ){
                   
                    flash(t("Username or password is incorrect"))->error();
                    if(Str::contains(url()->previous(), '/' . trans('routes.login'))){
                        return redirect($this->loginPath);
                    }else{
                        return redirect($this->redirectTo);
                    }
                }

                // GET A SESSION FOR USER
                if (Auth::loginUsingId($user->id)) {


                    // check user is partner or model and redirect to dashobard accroding to it
                    $this->redirectTo = config('app.locale') . '/' . trans('routes.partner-dashboard');
                    if( $user->user_type_id == config('constant.model_type_id') ){
                        $this->redirectTo = config('app.locale') . '/' . trans('routes.model-dashboard');
                    }

                    return redirect($this->redirectTo);
                    
                } else {
                    $message = t("Error on user's login.");
                    flash($message)->error();
                    
                    return redirect($this->loginPath);
                }
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if (is_string($message) && !empty($message)) {
                flash($message)->error();
            } else {
                $message = "Unknown error. The service does not work.";
                flash($message)->error();
            }
            
            return redirect($this->loginPath);
        }
    }
}
