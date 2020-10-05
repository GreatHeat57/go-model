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

namespace App\Http\Controllers\Post;

use App\Helpers\CommonHelper;
use App\Helpers\Payment as PaymentHelper;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Post\Traits\PaymentTrait;
use App\Http\Requests\PackageRequest;
use App\Mail\PostCreatePackage;
use App\Models\Category;
use App\Models\Package;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Post;
use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\StrictActiveScope;
use App\Models\Scopes\VerifiedScope;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Torann\LaravelMetaTags\Facades\MetaTag;

class PackageController extends FrontController {
	use PaymentTrait;

	public $request;
	public $data;
	public $msg = [];
	public $uri = [];
	public $packages;
	public $paymentMethods;

	/**
	 * PackageController constructor.
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
		
		// From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next) {
			$this->request = $request;
			$this->commonQueries();
			// get terms and conditions for country code wise
			$this->getTermsConditions();

			return $next($request);
		});
	}

	/**
	 * Common Queries
	 */
	public function commonQueries() {
		// Messages
		if (getSegment(2) == 'create') {
			$this->msg['post']['success'] = t("Your ad has been created");
		} else {
			$this->msg['post']['success'] = t("Your job has been updated");
		}
		$this->msg['checkout']['success'] = t("We have received your payment");
		$this->msg['checkout']['cancel'] = t("We have not received your payment, Payment cancelled");
		$this->msg['checkout']['error'] = t("We have not received your payment, An error occurred");

		// Set URLs
		if (getSegment(2) == 'create') {
			$this->uri['previousUrl'] = config('app.locale') . '/posts/create/#entryToken/packages';
			$this->uri['nextUrl'] = config('app.locale') . '/posts/create/#entryToken/finish';
			$this->uri['paymentCancelUrl'] = url(config('app.locale') . '/posts/create/#entryToken/payment/cancel');
			$this->uri['paymentReturnUrl'] = url(config('app.locale') . '/posts/create/#entryToken/payment/success');
		} else {
			$this->uri['previousUrl'] = config('app.locale') . '/posts/#entryId/packages';
			$this->uri['nextUrl'] = config('app.locale') . '/' . trans('routes.v-post', ['slug' => '#title', 'id' => '#entryId']);
			$this->uri['paymentCancelUrl'] = url(config('app.locale') . '/posts/#entryId/payment/cancel');
			$this->uri['paymentReturnUrl'] = url(config('app.locale') . '/posts/#entryId/payment/success');
		}

		// Payment Helper init.
		PaymentHelper::$country = collect(config('country'));
		PaymentHelper::$lang = collect(config('lang'));
		PaymentHelper::$msg = $this->msg;
		PaymentHelper::$uri = $this->uri;

		// Get Packages
		$this->packages = Package::where('user_type_id', 2)->where('country_code', config("country.code"))->trans()->applyCurrency()->with('currency')->orderBy('lft')->get();
		view()->share('packages', $this->packages);
		view()->share('countPackages', $this->packages->count());

		// Keep the Post's creation message
		// session()->keep(['message']);
		if (getSegment(2) == 'create') {
			if (session()->has('tmpPostId')) {
				session()->flash('message', t('Your ad has been created'));
			}
		}
	}

	/**
	 * Show the form the create a new ad post.
	 *
	 * @param $postIdOrToken
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getForm($postIdOrToken) {
		$data = [];

		// Get Post
		if (getSegment(2) == 'create') {
			if (!Session::has('tmpPostId')) {
				return redirect('posts/create');
			}
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $postIdOrToken)->first();
		} else {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('user_id', auth()->user()->id)->where('id', $postIdOrToken)->first();
		}

		if (empty($post)) {
			abort(404);
		}
		view()->share('post', $post);

		// Get parent Category (for wizard nav.)
		$pcat = Category::transById($post->category_id);
		if (!empty($pcat)) {
			if ($pcat->parent_id != 0) {
				$pcat = Category::find($pcat->parent_id);
			}
		}
		view()->share('pcat', $pcat);

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

		// Meta Tags
		if (getSegment(2) == 'create') {
			// MetaTag::set('title', getMetaTag('title', 'create'));
			// MetaTag::set('description', strip_tags(getMetaTag('description', 'create')));
			// MetaTag::set('keywords', getMetaTag('keywords', 'create'));

			$tags = getAllMetaTagsForPage('create');
			$title = isset($tags['title']) ? $tags['title'] : '';
	        $description = isset($tags['description']) ? $tags['description'] : '';
	        $keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

	        // Meta Tags
	        MetaTag::set('title', $title);
	        MetaTag::set('description', strip_tags($description));
	        MetaTag::set('keywords', $keywords);

		} else {
			MetaTag::set('title', t('Update My Ad'));
			MetaTag::set('description', t('Update My Ad'));
		}

		return view('post.packages', $data);
	}

	/**
	 * Store a new ad post.
	 *
	 * @param $postIdOrToken
	 * @param PackageRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function postForm($postIdOrToken, PackageRequest $request) {
		// Get Post
		if (getSegment(2) == 'create') {
			if (!Session::has('tmpPostId')) {
				return redirect('posts/create');
			}
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('id', session('tmpPostId'))->where('tmp_token', $postIdOrToken)->first();
		} else {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('user_id', auth()->user()->id)->where('id', $postIdOrToken)->first();
		}

		if (empty($post)) {
			abort(404);
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
		$paymentMethods = PaymentMethod::find($request->input('payment_method'));
		if (!empty($package) && $package->price > 0 && $request->filled('payment_method') && !$alreadyPaidPackage) {
			$req_arr = array(
				'action' => 'create_sub', //required
				'wpusername' => auth()->user() ? auth()->user()->username : '', // required
				'transactionid' => $post->id,
				'gateway' => $paymentMethods->name,
				'type' => $request->get('accept_method'),
				'currency' => $package->currency_code,
				'description' => $package->name,
				// 'uid' 			=>  $subid,
				'rescission' => '',
			);
			/* var_dump($req_arr);*/
			$response = CommonHelper::go_call_request($req_arr);
			Log::info('Request Array ', ['Request Array create_sub' => $req_arr]);

			$json = json_decode($response->getBody());
			Log::info('Response Array', ['Response Array create_sub' => $json]);

			if ($response->getStatusCode() == 200) {
				return $this->sendPayment($request, $post);
			}

			/*create post mail*/

			Mail::to($post->user->email)->send(new PostCreatePackage($post));

		}

		// IF NO PAYMENT IS MADE (CONTINUE)

		// Get the next URL
		if (getSegment(2) == 'create') {
			$request->session()->flash('message', t('Your ad has been created'));
			$nextStepUrl = config('app.locale') . '/posts/create/' . $postIdOrToken . '/finish';
		} else {
			flash(t("Your job has been updated"))->success();
			$nextStepUrl = config('app.locale') . '/' . $post->uri;
		}

		// Redirect
		return redirect($nextStepUrl);
	}

	public function getShowPackageInfo($id) {

		$packages = Package::where('id', $id)->first();
		$data['package'] = $packages;
		return view('post.post-info-zoom', $data);
	}
}
