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
use Illuminate\Support\Facades\Event;
use App\Events\UserWasLogged;
use App\Http\Controllers\FrontController;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Str;

class LoginController extends FrontController {
	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */
	// If not logged in redirect to
	protected $loginPath = 'login';

	// The maximum number of attempts to allow
	protected $maxAttempts = 5;

	// The number of minutes to throttle for
	protected $decayMinutes = 15;

	// After you've logged in redirect to
	protected $redirectTo = 'account';

	// After you've logged out redirect to
	protected $redirectAfterLogout = '/';

	/**
	 * LoginController constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->middleware('guest')->except(['except' => 'logout']);

		// Set default URLs
		//$isFromLoginPage = Str::contains(url()->previous(), '/' . trans('routes.login'));
		$this->loginPath = config('app.locale') . '/' . trans('routes.login');
		$this->redirectTo = config('app.locale') . '/' . trans('routes.model-dashboard');
		// $this->redirectAfterLogout = config('app.locale') . '/' . trans('routes.login');
		$this->redirectAfterLogout = config('app.locale');

		// Get values from Config
		$this->maxAttempts = (int) config('settings.security.login_max_attempts', $this->maxAttempts);
		$this->decayMinutes = (int) config('settings.security.login_decay_minutes', $this->decayMinutes);

		$userTypes = UserType::orderBy('id', 'DESC')->get();
		view()->share('userTypes', $userTypes);

		// $page_terms = $page_termsclient = array();
		// if(isset($this->pages) && !empty($this->pages) && $this->pages->count() > 0){
		// 	foreach($this->pages as $page){
		// 		if($page->type == "terms"){
		// 			$page_terms = $page;
		// 		}elseif($page->type == "termsclient") {
		// 			$page_termsclient = $page;
		// 		}
		// 	}
		// }
		// view()->share('page_terms', $page_terms);
		// view()->share('page_termsclient', $page_termsclient);

		// From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next) {
			// get terms and conditions for country code wise
			$this->getTermsConditions();

			return $next($request);
		});
	}

	// -------------------------------------------------------
	// Laravel overwrites for loading JobClass views
	// -------------------------------------------------------

	/**
	 * Show the application login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showLoginForm() {
		// Remembering Login
		if (Auth::viaRemember()) {
			return redirect()->intended($this->redirectTo);
		}

		// set cookies value as 0 for user is not logged in
		setcookie('go_models_loggedin', 0);

		// Meta Tags
		// MetaTag::set('title', getMetaTag('title', 'login'));
		// MetaTag::set('description', strip_tags(getMetaTag('description', 'login')));
		// MetaTag::set('keywords', getMetaTag('keywords', 'login'));
		$tags = getAllMetaTagsForPage('login');
		$title = isset($tags['title']) ? $tags['title'] : '';
		$description = isset($tags['description']) ? $tags['description'] : '';
		$keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', strip_tags($description));
		MetaTag::set('keywords', $keywords);
		
		return view('auth.login');
	}

	/**
	 * @param LoginRequest $request
	 * @return $this|\Illuminate\Http\RedirectResponse|void
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function login(LoginRequest $request) {

		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		// if ($this->hasTooManyLoginAttempts($request)) {
		// 	$this->fireLockoutEvent($request);

		// 	return $this->sendLockoutResponse($request);
		// }

		// Get the right login field
		$loginField = getLoginField($request->input('login'));

		// Get credentials values
		$credentials = [
			$loginField => $request->input('login'),
			'password' => $request->input('password'),
			'blocked' => 0,
			//'subscribed_payment' => 'complete',
		];

		//old login code for only email
		/*if (in_array($loginField, ['email', 'phone'])) {
	            $credentials['verified_' . $loginField] = 1;
	        } else {
	            $credentials['verified_email'] = 1;
	            $credentials['verified_phone'] = 1;
		*/

		if (in_array($loginField, ['email', 'phone', 'username'])) {
			$credentials['verified_email'] = 1;
		}

		$user = User::where($loginField, $request->input('login'))->where('closed', 0)->first();
		if ($user) {
			if ($user->active) {

				if (Auth::attempt($credentials)) {


					//if logged in user is blocked then redirect the user
					if( Auth::User()->subscribed_payment !== 'complete' ){
						
						// logout session auth
						Auth::logout();

						$error = \Illuminate\Validation\ValidationException::withMessages([
						   'login' => [trans('global.Your contract payment is pending')]
						]);
						throw $error;
					}

					// Update last user logged Date
					Event::dispatch(new UserWasLogged(User::find(Auth::user()->id)));

					// set cookies value as 1 for user is logged in
					setcookie('go_models_loggedin', 1);

					if (Auth::User()->user_type_id == config('constant.partner_type_id')) {
						// if(config('app.locale') == "en"){
						// 	$this->redirectTo = '/' . trans('routes.partner-dashboard');
						// }else{
							$this->redirectTo = config('app.locale') . '/' . trans('routes.partner-dashboard');
						// }
					}

					if (Auth::User()->user_type_id == config('constant.model_type_id')) {
						
						// check loggedin user profile completed. and not complete 
						if(Auth::User()->is_profile_completed == '0'){
							
							$attr = ['countryCode' => config('app.locale')];
							return redirect(lurl(trans('routes.profile-edit', $attr), $attr));
						}


						// if(config('app.locale') == "en"){
						// 	$this->redirectTo = '/' . trans('routes.model-dashboard');
						// }else{
							$this->redirectTo = config('app.locale') . '/' . trans('routes.model-dashboard');
						// }
					}

					if (Auth::User()->user_type_id == 1) {
						$this->redirectTo = '/'.config('larapen.admin.route_prefix', 'admin');
					}
					return redirect()->intended($this->redirectTo); //old redirection code
					// return redirect('account/social');
				}else{

					$error = \Illuminate\Validation\ValidationException::withMessages([
					   'login' => [trans('global.Username or password is incorrect')]
					]);
					throw $error;
				}

			}else{
					$error = \Illuminate\Validation\ValidationException::withMessages([
					   'login' => [trans('global.user account is not activated')]
					]);
					throw $error;
			}
		}else{
			$error = \Illuminate\Validation\ValidationException::withMessages([
			   'login' => [trans("global.Sorry, we don't recognize that email address")]
			]);
			throw $error;
		}

		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		// $this->incrementLoginAttempts($request);

		// Check and retrieve previous URL to show the login error on it.
		if (session()->has('url.intended')) {
			$this->loginPath = session()->get('url.intended');
		}

		return redirect($this->loginPath)->withErrors(['error' => trans('auth.failed')])->withInput();
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function logout(Request $request) {
		// Get the current Country
		if (session()->has('country_code')) {
			$countryCode = session('country_code');
		}

		// Remove all session vars
		$this->guard()->logout();
		$request->session()->flush();
		$request->session()->regenerate();

		// Retrieve the current Country
		if (isset($countryCode) && !empty($countryCode)) {
			session(['country_code' => $countryCode]);
		}

		// set cookies value as 0 for user is logged out from the systems
		setcookie('go_models_loggedin', 0);

		$message = t('You have been logged out') . ' ' . t('See you soon');
		flash($message)->success();

		return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
	}
}
