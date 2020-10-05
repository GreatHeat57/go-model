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

use App\Helpers\Arr;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Post\Traits\EditTrait;
use App\Http\Requests\ReportRequest;
use App\Mail\ReportSent;
use App\Models\Post;
use App\Models\ReportType;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ReportController extends FrontController {
	use EditTrait;

	/**
	 * ReportController constructor.
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
		// Get Report abuse types
		$reportTypes = ReportType::trans()->get();
		view()->share('reportTypes', $reportTypes);
	}

	public function showReportForm($postId) {
		$data = [];

		if (isset($postId) && !empty($postId)) {

			$postData = $this->getPostByID($postId);

			if (empty($postData)) {
				abort(404);
			}

			// // Get Post
			// $data['post'] = Post::find($postId);
			// if (empty($data['post'])) {
			//     abort(404);
			// }

			$data['post'] = $postData;

			// Meta Tags
			$data['title'] = t('Report for :title', ['title' => ucfirst($data['post']->title)]);
			$description = t('Send a report for :title', ['title' => ucfirst($data['post']->title)]);

			MetaTag::set('title', $data['title']);
			MetaTag::set('description', strip_tags($description));

			// Open Graph
			$this->og->title($data['title'])->description($description);
			view()->share('og', $this->og);

			return view('post.report', $data);
		} else {

			flash(t('Unknown error, Please try again in a few minutes'))->error();
			return back();
		}
	}

	/**
	 * @param $postId
	 * @param ReportRequest $request
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function sendReport($postId, Request $request) {
		
		$json = array();

		$rules = [
			'report_type' => 'required|not_in:0',
			'email' => 'required|email|max:100',
			'message' => 'required|mb_between:20,500',
			'post' => 'required|numeric',
		];

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			$json['status'] = false;
			$json['errors'] = $validator->getMessageBag()->toArray();
			return response()->json($json, 200);
		}

		$post = $this->getPostByID($request->post);

		if (empty($post)) {
			abort(404);
		}

		// Store Report
		$report = [
			'post_id' => $request->post,
			'report_type_id' => $request->input('report_type'),
			'email' => $request->input('email'),
			'message' => $request->input('message'),
		];

		// Send Abuse Report to admin
		try {
			
			if (config('app.suppport_email')) {
				$recipient = [
					'email' => config('app.suppport_email'),
					'name' => config('settings.app.name'),
				];
				$recipient = Arr::toObject($recipient);
				Mail::send(new ReportSent($post, $report, $recipient));
			} else {
				$admins = User::where('is_admin', 1)->get();
				if ($admins->count() > 0) {
					foreach ($admins as $admin) {
						Mail::send(new ReportSent($post, $report, $admin));
					}
				}
			}
			
			$json['status'] = true;
			$json['message'] = t('Your report has sent successfully to us, Thank you!');
		} catch (\Exception $e) {
			$json['status'] = false;
			$json['errors'] = t("Unknown error, Please try again in a few minutes");
		} 

		return response()->json($json, 200);
	}

}
