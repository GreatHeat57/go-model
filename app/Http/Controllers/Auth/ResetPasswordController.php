<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Traits\ResetsPasswordsUsingTokenTrait;
use App\Http\Controllers\FrontController;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Models\UserType;
use App\Models\User;

class ResetPasswordController extends FrontController {
	use ResetsPasswords, ResetsPasswordsUsingTokenTrait;

	/**
	 * Where to redirect users after resetting their password.
	 *
	 * @var string
	 */
	protected $redirectTo = '/account';

	/**
	 * ResetPasswordController constructor.
	 */
	public function __construct() {
		parent::__construct();
		
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


		$this->redirectTo = config('lang.abbr') . '/account';

		$this->middleware('guest');

		$userTypes = UserType::orderBy('id', 'DESC')->get();
		view()->share('userTypes', $userTypes);
	}

	// -------------------------------------------------------
	// Laravel overwrites for loading JobClass views
	// -------------------------------------------------------

	/**
	 * Display the password reset view for the given token.
	 *
	 * If no token is present, display the link request form.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param string|null $token
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showResetForm(Request $request, $token = null) {
		// Meta Tags
		view()->share('uriPathToken', $token);
		MetaTag::set('title', t('Reset Password'));
		MetaTag::set('description', t('Reset your Password'));
		return view('auth.passwords.reset')->with(['token' => $token, 'email' => $request->email]);
	}

	/**
	 * Reset the given user's password.
	 *
	 * @param ResetPasswordRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function reset(ResetPasswordRequest $request) {

		// IF EMAIL NOT GET IN REUEST THEN GET USER EMAIL FROM USERNAME
		if (!filter_var($request->input('login'), FILTER_VALIDATE_EMAIL)) {
			$user = User::where('email', $request->input('login'))->orWhere('username', $request->input('login'))->first();
			
			// IF USER FOUND THEN UPDATE EMAIL IN REQUEST INPUT VALUE
			if( isset($user) && !empty($user) && !empty($user->email)){
				$request->merge(['login' => $user->email]);
			}
		}


		// Get the right login field
		$field = getLoginField($request->input('login'));
		$request->merge([$field => $request->input('login')]);
		if ($field != 'email') {
			$request->merge(['email' => $request->input('login')]);
		}

		// Go to the custom process (Phone)
		if ($field == 'phone') {
			return $this->resetPasswordUsingToken($request);
		}

		// Go to the core process (Email)

		// Here we will attempt to reset the user's password. If it is successful we
		// will update the password on an actual user model and persist it to the
		// database. Otherwise we will parse the error and return the response.
		$response = $this->broker()->reset(
			$this->credentials($request), function ($user, $password) {
				// if ($user->user_type_id == 3) {
				// 	$this->redirectTo = config('lang.abbr') . '/' . trans('routes.model-dashboard');
				// } else {
				// 	$this->redirectTo = config('lang.abbr') . '/' . trans('routes.partner-dashboard');
				// }
				$this->redirectTo = config('lang.abbr') . '/' . trans('routes.login');

				$this->resetPassword($user, $password);
			}
		);

		// If the password was successfully reset, we will redirect the user back to
		// the application's home authenticated view. If there is an error we can
		// redirect them back to where they came from with their error message.
		return $response == Password::PASSWORD_RESET
		? $this->sendResetResponse($request, $response)
		: $this->sendResetFailedResponse($request, $response);
	}

	/**
	 * Reset the given user's password.
	 *
	 * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
	 * @param  string $password
	 * @return void
	 */
	protected function resetPassword($user, $password) {
		$userInfo = [
			'password' => bcrypt($password),
			'remember_token' => Str::random(60),
			'verified_email' => 1, // Email auto-verified
		];

		if ($user->is_admin == 1) {
			// Phone auto-verified
			$userInfo['verified_phone'] = 1;
		}

		$user->forceFill($userInfo)->save();

		//disable auto login
		//$this->guard()->login($user);
	}
}
