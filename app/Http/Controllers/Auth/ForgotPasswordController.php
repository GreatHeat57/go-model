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

use App\Http\Controllers\Auth\Traits\SendsPasswordResetSmsTrait;
use App\Http\Controllers\FrontController;
use App\Http\Requests\ForgotPasswordRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Models\UserType;

class ForgotPasswordController extends FrontController {
	use SendsPasswordResetEmails {
		sendResetLinkEmail as public traitSendResetLinkEmail;
	}
	use SendsPasswordResetSmsTrait;

	protected $redirectTo = '/account';

	/**
	 * PasswordController constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->middleware('guest');
		
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

		$userTypes = UserType::orderBy('id', 'DESC')->get();
		view()->share('userTypes', $userTypes);
	}

	// -------------------------------------------------------
	// Laravel overwrites for loading LaraClassified views
	// -------------------------------------------------------

	/**
	 * Display the form to request a password reset link.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showLinkRequestForm() {
		// Meta Tags
		// MetaTag::set('title', getMetaTag('title', 'password'));
		// MetaTag::set('description', strip_tags(getMetaTag('description', 'password')));
		// MetaTag::set('keywords', getMetaTag('keywords', 'password'));
		$tags = getAllMetaTagsForPage('password');
		$title = isset($tags['title']) ? $tags['title'] : '';
		$description = isset($tags['description']) ? $tags['description'] : '';
		$keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', strip_tags($description));
		MetaTag::set('keywords', $keywords);

		// return view('auth.passwords.email');
		return view('auth/reset_password');
	}

	/**
	 * Send a reset link to the given user.
	 *
	 * @param ForgotPasswordRequest $request
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function sendResetLinkEmail(ForgotPasswordRequest $request) {

		// check given input value with email or username
		$user = User::where('email', $request->input('email'))->orWhere('username', $request->input('email'))->first();

		\Log::info('sendResetLinkEmail', ["user object" => json_decode($user)]);

		if( isset($user) && !empty($user) && ($user->active == 0 || $user->blocked == 1)){
			$message = ($user->blocked == 1)? t("user_account_suspened") : t("Your account is not activated");
			flash($message)->error();
			\Log::info('sendResetLinkEmail', ['Your account is not activated']);
			return redirect(config('app.locale') . '/' . trans('routes.password-reset'))->withInput();
		}

		if( isset($user) && !empty($user) && !empty($user->provider)){
			flash(t("Sorry, we don't recognize that email address"))->error();
			\Log::info('sendResetLinkEmail', ["Sorry, we don't recognize that email address"]);
			return redirect(config('app.locale') . '/' . trans('routes.password-reset'))->withInput();
		}

		if (empty($user)) {
			flash(t("Sorry, we don't recognize that email address"))->error();
			\Log::info('sendResetLinkEmail', ["Sorry, we don't recognize that email address"]);
			return redirect(config('app.locale') . '/' . trans('routes.password-reset'))->withInput();
		}

		//user type is model then check contract sign
		if( isset($user) && !empty($user) && ( $user->user_type_id == config('constant.model_type_id') ) &&  $user->active == 1){
			if( isset($user->country->country_type) && $user->country->country_type === config('constant.country_premium') && $user->subscribed_payment !== 'complete'){
				flash(t("Your contract payment is pending"))->error();
				\Log::info('sendResetLinkEmail', ["Your contract payment is pending"]);
				return redirect(config('app.locale') . '/' . trans('routes.password-reset'))->withInput();
			}
		}

		// temp disable the reset token send on mobile
		// Get the right login field
		/*
		$field = getLoginField($request->input('login'));
		$request->merge([$field => $request->input('login')]);
		if ($field != 'email') {
			$request->merge(['email' => $request->input('login')]);
		}

		// Send the Token by SMS
		if ($field == 'phone') {
			return $this->sendResetTokenSms($request);
		}*/

		// check if user reset using user name and email is empty then redirect back
		if( isset($user) && !empty($user) && empty($user->email)){
			flash(t("Sorry, we don't recognize that email address"))->error();
			\Log::info('sendResetLinkEmail', ["Sorry, we don't recognize that email address"]);
			return redirect(config('app.locale') . '/' . trans('routes.password-reset'))->withInput();
		}

		if( isset($user) && !empty($user) && ($user->active == 1)){

			// update user email address if reset using username
			$request->merge(['email' => $user->email]);

			// Go to the core process
			return $this->traitSendResetLinkEmail($request);
		}
		\Log::info('sendResetLinkEmail', ["return null from here"]);
	}
}
