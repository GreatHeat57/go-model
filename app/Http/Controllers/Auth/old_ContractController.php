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

use App\Helpers\CommonHelper;
use App\Helpers\Payment as PaymentHelper;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Post\Traits\PaymentTrait;
use App\Http\Requests\PackageRequest;
use App\Mail\PaymentNotificationAfterSuccess;
use App\Models\Gender;
use App\Models\Package;
use App\Models\Page;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Post;
use App\Models\Scopes\FromActivatedCategoryScope;
use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\StrictActiveScope;
use App\Models\Scopes\VerifiedScope;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Torann\LaravelMetaTags\Facades\MetaTag;

class old_ContractController extends FrontController {
	use PaymentTrait;

	public $request;
	public $data;
	public $msg = [];
	public $uri = [];
	public $packages;
	public $paymentMethods;

	/**
	 * @var array
	 */

	/**
	 * ContractController constructor.
	 */
	public function __construct() {
		parent::__construct();

		$page_terms = $page_termsclient = array();
        if(isset($this->pages) && !empty($this->pages) && $this->pages->count() > 0){
            foreach($this->pages as $page){
                if($page->type == "terms"){
                    $page_terms = $page;
                }elseif($page->type == "termsclient") {
                    $page_termsclient = $page;
                }
            }
        }
        view()->share('page_terms', $page_terms);
        view()->share('page_termsclient', $page_termsclient);

		// From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next) {
			$this->request = $request;
			$this->commonQueries();

			return $next($request);
		});
	}

	/**
	 * Common Queries
	 */
	public function commonQueries() {
		// Messages
		if (getSegment(2) == 'create') {
			$this->msg['post']['success'] = '';
		} else {
			$this->msg['post']['success'] = '';
		}
		$this->msg['checkout']['success'] = t("We have received your payment");
		$this->msg['checkout']['cancel'] = t("We have not received your payment, Payment cancelled");
		$this->msg['checkout']['error'] = t("We have not received your payment, An error occurred");

		// Set URLs
		if (getSegment(2) == 'create') {
			$this->uri['previousUrl'] = config('app.locale') . '/contract/create/#entryToken/payPackages';
			$this->uri['nextUrl'] = config('app.locale') . '/contract/create/#entryToken/finish';
			$this->uri['paymentCancelUrl'] = url(config('app.locale') . '/contract/create/#entryToken/payment/cancel');
			$this->uri['paymentReturnUrl'] = url(config('app.locale') . '/contract/create/#entryToken/payment/success');
		} else {
			$this->uri['previousUrl'] = config('app.locale') . '/contract/#entryId/packages';
			$this->uri['nextUrl'] = config('app.locale') . '/' . trans('routes.v-post', ['slug' => '#title', 'id' => '#entryId']);
			$this->uri['paymentCancelUrl'] = url(config('app.locale') . '/contract/#entryId/payment/cancel');
			$this->uri['paymentReturnUrl'] = url(config('app.locale') . '/contract/#entryId/payment/success');
		}

		// Payment Helper init.
		PaymentHelper::$country = collect(config('country'));
		PaymentHelper::$lang = collect(config('lang'));
		PaymentHelper::$msg = $this->msg;
		PaymentHelper::$uri = $this->uri;

		// Get Packages
		$this->packages = Package::where('user_type_id', 3)->where('country_code', config("country.code"))->trans()->applyCurrency()->with('currency')->orderBy('lft')->get();
		view()->share('packages', $this->packages);
		view()->share('countPackages', $this->packages->count());

	}

	/**
	 * Show the form the create a new user account.
	 *
	 * @return View
	 */
	public function redirectLink($locale, Request $request) {
		if (in_array($locale, ['at', 'ch', 'li'])) {
			$code = $request->input('code');
			$id = $request->input('id');
			$subid = $request->input('subid');
			$locale = strtoupper($locale);
			$query = '?d=' . $locale . '&code=' . $code . '&id=' . $id . '$subid=' . $subid;

			return redirect(config('app.locale') . '/contract/create' . $query);
		} else {
			echo 'Something went wrong';
		}
	}

	public function showProfileForm(Request $request) {

		$slug = $request->get('code');
		$time = substr($slug, 0, 10);
		$remain_slug = substr($slug, 10);
		$id = $remain_slug / ($time * 2);

		$check = \DB::table('posts')->where('user_id', $id)->orderBy('id', 'desc')->first();

		if ($check) {
			return redirect(config('app.locale') . '/contract/create/' . $check->tmp_token . '/packages?' . 'code=' . $check->code_without_md5 . '&id=' . $check->username . '&subid=' . $check->subid . '&package=' . $check->package);
		}

		$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class, FromActivatedCategoryScope::class])->where('code_token', md5($slug))->where('ismade', 1)->first();

		$user = User::find($id);

		if ($user->user_type_id == 2 && $user->password == null) {
			$req_arr = array(
				'action' => 'generate_pw', //required
				'wpusername' => $user->username, // required
			);

			$response = CommonHelper::go_call_request($req_arr);
			if ($response->getStatusCode() == 200) {
				$body = (string) $response->getBody();
				$user->password = bcrypt($body);

				$req_arr = array(
					'action' => 'activate', //required
					'wpusername' => $user->username, // required
				);

				$res = CommonHelper::go_call_request($req_arr);
				if ($res->getStatusCode() == 200) {
					$user->active = 1;
				}
				$user->save();
			}
		}

		if ($post || $user->password != null) {
			$nextUrl = config('app.locale') . '/';
			$request->session()->flash('message', t('You already made signed this contract'));
			return redirect($nextUrl);
		}

		$page = Page::where('slug', 'terms')->trans()->first();
		if (empty($page)) {
			abort(404);
		}
		view()->share('page', $page);

		if ($request->get('subid') == '_access_free') {
			$this->packages = Package::where('price', 0.00)->where('user_type_id', 3)->where('country_code', config("country.code"))->trans()->applyCurrency()->with('currency')->orderBy('lft')->get();
		} elseif ($request->get('subid') == '_access') {
			$this->packages = Package::where('price', '>', 0.00)->where('user_type_id', 3)->where('country_code', config("country.code"))->trans()->applyCurrency()->with('currency')->orderBy('lft')->get();
		} elseif ($request->get('subid') == '_access_both') {
			$this->packages = Package::where('user_type_id', 3)->where('country_code', config("country.code"))->trans()->applyCurrency()->with('currency')->orderBy('lft')->get();
		} else {
			return redirect(config('app.locale') . '/');
		}

		view()->share('packages', $this->packages);
		view()->share('countPackages', $this->packages->count());

		$data = [];
		$data['user'] = $user;
		$data['uriPath'] = 'yourContract';
		$data['code'] = $slug;
		$data['id'] = $request->get('id');
		$data['subid'] = $request->get('subid');
		$data['genders'] = Gender::trans()->get();

		$data['siteCountryInfo'] = NULL;

		return view('contract.profile', $data);
	}

	public function showPackagesForm($postIdOrToken, Request $request) {

		$data = $request->session()->all();

		if (Session::has('tmpPostId')) {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class, FromActivatedCategoryScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $postIdOrToken)->first();
		}

		if (isset($post)) {
			view()->share('post', $post);
			$post->save();
		}

		if ($request->get('subid') == '_access_free') {
			$this->packages = Package::where('translation_of', $request->get('package'))->where('price', 0.00)->where('user_type_id', 3)->where('country_code', config("country.code"))->trans()->applyCurrency()->with('currency')->orderBy('lft')->get();
		} elseif ($request->get('subid') == '_access') {
			$this->packages = Package::where('translation_of', $request->get('package'))->where('price', '>', 0.00)->where('user_type_id', 3)->where('country_code', config("country.code"))->trans()->applyCurrency()->with('currency')->orderBy('lft')->get();
		} elseif ($request->get('subid') == '_access_both') {
			$this->packages = Package::where('translation_of', $request->get('package'))->where('user_type_id', 3)->where('country_code', config("country.code"))->trans()->applyCurrency()->with('currency')->orderBy('lft')->get();
		} else {
			return redirect(config('app.locale') . '/');
		}

		view()->share('packages', $this->packages);
		view()->share('countPackages', $this->packages->count());

		// Get current Payment
		$currentPayment = null;

		if ($post->featured == 1) {
			$currentPayment = Payment::withoutGlobalScope(StrictActiveScope::class)
				->where('post_id', $post->id)
				->orderBy('created_at', 'DESC')
				->first();
		}
		view()->share('currentPayment', $currentPayment);

		// Get the package of the current payment (if exists)
		if (isset($currentPayment) && !empty($currentPayment)) {
			$currentPaymentPackage = Package::transById($currentPayment->package_id);
			view()->share('currentPaymentPackage', $currentPaymentPackage);
		}

		$slug = $request->get('code');
		$time = substr($slug, 0, 10);
		$remain_slug = substr($slug, 10);
		$id = $remain_slug / ($time * 2);

		$data = [];
		$data['user'] = User::find($id);
		$data['uriPath'] = 'payment';
		$data['siteCountryInfo'] = NULL;
		$data['code'] = $request->get('code');
		$data['id'] = $request->get('id');
		$data['subid'] = $request->get('subid');

		return view('contract.packages', $data);
	}

	public function profileUpdate(Request $request) {
		$user = User::find($request->input('user_id'));

		$req_arr = array(
			'action' => 'update', //required
			'wpusername' => $user->username, // required api
			'name' => $request->input('first_name'),
			'lname' => $request->input('first_name'),
			'email' => $user->email,
			'street' => $request->input('street'),
			'zip' => $request->input('zip'),
			'city' => $request->input('city'),
			'country' => config('app.locale'),
			'birthday' => $request->input('cs_birthday_birthDay'),
			'gender' => $request->input('gender'),
		);

		$response = CommonHelper::go_call_request($req_arr);
		if ($response->getStatusCode() == 200) {
			$body = (string) $response->getBody();
			if ($body) {
				$user->gender_id = $request->input('gender');
				$user->profile->birth_day = $request->input('cs_birthday_birthDay');
				$user->profile->first_name = $request->input('first_name');
				$user->profile->last_name = $request->input('last_name');
				$user->profile->fname_parent = $request->input('fname_parent');
				$user->profile->lname_parent = $request->input('lname_parent');
				$user->profile->street = $request->input('street');
				$user->profile->city = $request->input('city');
				$user->profile->zip = $request->input('zip');

				// Save
				$user->save();
				$user->profile->save();

				flash(t("Your account profile has updated successfully"))->success();
			}
		}
		return redirect()->back();
	}

	public function postProfile(Request $request) {
		$package = $request->input('package');
		$code = $request->input('code');
		$time = substr($code, 0, 10);
		$remain_code = substr($code, 10);
		$id = $remain_code / ($time * 2);
		$username = $request->input('id');
		$subid = $request->input('subid');
		$user = User::find($id);

		// Post Data
		$postInfo = [
			'country_code' => config('country.code'),
			'user_id' => $id,
			'category_id' => 0,
			'title' => '',
			'description' => '',
			'contact_name' => '',
			'city_id' => 0,
			'email' => $user->email,
			'tmp_token' => md5(microtime() . mt_rand(100000, 999999)),
			'code_token' => md5($code),
			'verified_email' => 1,
			'verified_phone' => 1,
			'username' => $username,
			'package' => $package,
			'subid' => $subid,
			'code_without_md5' => $code,
		];
		$post = new Post($postInfo);
		$post->save();

		// Save ad Id in session (for next steps)
		session(['tmpPostId' => $post->id]);

		return redirect(config('app.locale') . '/contract/create/' . $post->tmp_token . '/packages?' . 'code=' . $code . '&id=' . $username . '&subid=' . $subid . '&package=' . $package);
	}

	public function postPackages($postIdOrToken, PackageRequest $request) {

		$code = $request->input('code');
		$time = substr($code, 0, 10);
		$remain_code = substr($code, 10);
		$id = $remain_code / ($time * 2);
		$username = $request->input('id');
		$subid = $request->input('subid');
		$user = User::find($id);

		Session::put('user_id', $id);
		Session::save();

		// Get Post
		if (Session::has('tmpPostId')) {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class, FromActivatedCategoryScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $postIdOrToken)->first();

		}

		// MAKE A PAYMENT (IF NEEDED)

		// Check if the selected Package has been already paid for this Post
		$alreadyPaidPackage = false;

		$currentPayment = Payment::where('post_id', $post->id)->orderBy('created_at', 'DESC')->first();

		if (!empty($currentPayment)) {
			if ($currentPayment->package_id == $request->input('package')) {
				$alreadyPaidPackage = true;
			}
		}

		// for get ip address and browser details
		// When you call the detect function you will get a result object, from the current user's agent.
		$browser_detail = \Browser::detect1($_SERVER['HTTP_USER_AGENT']);

		// Function to get the client IP address
		$id_address = \Request::getClientIp(true);
		//  for get ip address and browser details

		// Check if Payment is required
		$package = Package::find($request->input('package'));
		$paymentMethods = PaymentMethod::find($request->input('payment_method'));

		if (!empty($package) && $package->price > 0 && $request->filled('payment_method') && !$alreadyPaidPackage) {

			if ($subid == '_access' || $subid == '_access_both') {

				$req_arr = array(
					'action' => 'create_sub', //required
					'wpusername' => auth()->user() ? auth()->user()->username : '', //$user->username, // required
					'transactionid' => $post->id,
					'gateway' => $paymentMethods->name,
					'type' => $request->get('accept_method'),
					'currency' => $package->currency_code,
					'description' => $package->name,
					'uid' => $subid,
					'rescission' => '',
					'ip' => $id_address,
					'agent' => $browser_detail,
				);

				$response = CommonHelper::go_call_request($req_arr);
				/*if ($response->getStatusCode() == 200) {

					return $this->sendPayment($request, $post);

				}*/

				/*if($response->getStatusCode() == 200){
					return $this->sendPayment($request, $post);
				}*/

				if ($request->input('payment_method') != '5') {
					/*mail system*/

					Mail::to($user->email)->send(new PaymentNotificationAfterSuccess($user));
					/*end mail system*/

				}

				if ($response->getStatusCode() == 200) {

					return $this->sendPayment($request, $post);

				}

			}
		} else {
			if ($subid == '_access_free' || $subid == '_access_both') {
				$req_arr = array(
					'action' => 'generate_pw', //required
					'wpusername' => $user->username, // required
				);

				$response = CommonHelper::go_call_request($req_arr);

				if ($response->getStatusCode() == 200) {

					$body = (string) $response->getBody();
					$user->password = bcrypt($body);

					$req_arr = array(
						'action' => 'activate', //required
						'wpusername' => $user->username, // required
					);

					$res = CommonHelper::go_call_request($req_arr);
					if ($res->getStatusCode() == 200) {
						$user->active = 1;
					}

					$user->save();
					$post->ismade = 1;
					$post->save();

					return redirect(config('app.locale') . '/contract/create/' . $postIdOrToken . '/finish');
				}
			}
		}
		// Get the next URL

		$nextStepUrl = config('app.locale') . '/';

		// Redirect

		return redirect($nextStepUrl);
	}

	public function payPackages($postIdOrToken, PackageRequest $request) {
		// Get Post
		if (Session::has('tmpPostId')) {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class, FromActivatedCategoryScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $postIdOrToken)->first();
		}

		// MAKE A PAYMENT (IF NEEDED)

		// Check if the selected Package has been already paid for this Post

		$alreadyPaidPackage = false;
		$currentPayment = Payment::where('post_id', $post->id)->orderBy('created_at', 'DESC')->first();
		if (!empty($currentPayment)) {
			if ($currentPayment->package_id == $request->input('package')) {
				$alreadyPaidPackage = true;
			}
		}

		// Check if Payment is required
		$package = Package::find($request->input('package'));
		if (!empty($package) && $package->price > 0 && !$alreadyPaidPackage) {
			//     // Send the Payment
			return $this->sendPayment($request, $post);
			// echo $package->price;
		}

		// IF NO PAYMENT IS MADE (CONTINUE)

		// Get the next URL
		$nextStepUrl = config('app.locale') . '/contract/create/' . $postIdOrToken . '/finish';

		// Redirect
		return redirect($nextStepUrl);
	}

	public function finish($tmpToken) {

		// Get Post
		if (Session::has('tmpPostId')) {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class, FromActivatedCategoryScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $tmpToken)->first();
		}

		if (session()->has('params')) {
			$params = session('params');
			$paymentMethods = PaymentMethod::find($params['payment_method']);
			$user = User::find(session('user_id'));
			$req_arr = array(
				'action' => 'pay', //required
				'wpusername' => $user->username, // required
				'transactionid' => $params['transaction_id'],
				'gateway' => $paymentMethods->name,
				'type' => $params['accept_method'],
				'currency' => $params['currency'],
				'description' => $params['description'],
				'amount' => $params['amount'],
			);

			$response = CommonHelper::go_call_request($req_arr);
			if ($response->getStatusCode() == 200) {

				$req_arr = array(
					'action' => 'generate_pw', //required
					'wpusername' => $user->username, // required
				);

				$response = CommonHelper::go_call_request($req_arr);
				if ($response->getStatusCode() == 200) {
					$body = (string) $response->getBody();
					$user->password = bcrypt($body);

					$req_arr_one = array(
						'action' => 'activate', //required
						'wpusername' => $user->username, // required
					);

					$res = CommonHelper::go_call_request($req_arr_one);
					if ($res->getStatusCode() == 200) {
						$user->active = 1;
					}

					$user->save();

					$post->ismade = 1;
					$post->save();
				}

			} else {
				return redirect(config('app.locale') . '/');
			}

			if (Session::has('params')) {
				Session::forget('params');
			}

		} else {
			return redirect(config('app.locale') . '/');
		}

		// Keep Success Message for the page refreshing
		session()->keep(['message']);
		if (!session()->has('message')) {
			return redirect(config('app.locale') . '/');
		}

		// Clear the steps wizard
		if (session()->has('tmpPostId')) {
			// Get the Post
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class, FromActivatedCategoryScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $tmpToken)->first();
			if (empty($post)) {
				abort(404);
			}

			// Apply finish actions
			$post->tmp_token = null;
			$post->save();
			session()->forget('tmpPostId');
		}

		$data['uriPath'] = 'finish';
		$data['siteCountryInfo'] = NULL;

		// Meta Tags
		MetaTag::set('title', session('message'));
		MetaTag::set('description', session('message'));

		return view('contract.finish', $data);
	}
}