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

namespace App\Http\Controllers\Account;

use App\Models\City;
use App\Models\Country;
use App\Models\Message;
use App\Models\User;
use App\Notifications\ContactSent;
use App\Notifications\ReplySent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Storage;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Models\Post;
use App\Mail\InviteEmail;
//add for unread massge email send
use App\Mail\MassgaeEmailSent;
use App\Mail\InvitationAccepted;
use Illuminate\Support\Facades\Mail;
use App\Models\UserProfile;
use App\Helpers\CommonHelper;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Cache;
use App\Models\ValidValue;
use App\Helpers\UnitMeasurement;
use App\Models\ExperienceType;
use Illuminate\Support\Facades\Event;
use App\Events\PostWasVisited;
use Jenssegers\Date\Date;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Search;
use App\Models\SavedPost;
use App\Models\ReportType;
use App\Models\Resume;
use App\Models\Category;
use App\Models\SalaryType;
use App\Models\PostType;
use DB;
use Illuminate\Support\Facades\Gate;
use App\Models\Page;
use Response;
use App\Notifications\DirectMessage;

class ConversationsController extends AccountBaseController {
	private $perPage = 10;

	public function __construct() {
		parent::__construct();

		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;
	}

	/**
	 * Conversations List
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request) {

		$data = [];

		if (auth()->user()->user_type_id ==  config('constant.model_type_id') && !Gate::allows('list_messages', auth()->user())) {
            flash("You are not allow to access this page")->error();
			return redirect(config('app.locale'));
        }

        // else if(Gate::allows('view_message_page', auth()->user())){
        // 	return $this->showMessagePage();
        // }

		// Set the Page Path
		view()->share('pagePath', 'conversations');
		
		$pageNo = 1;
		$start = 0;

		$limit = config('constant.messages_limit');

		$pageNo = ($request->page)? $request->page : 1;
		$start =  ($pageNo - 1) * $limit;
		
		$data['is_last_page'] = 0;
		
		$curentRecordCount = $limit + $start;

		$search = '';

		if(isset($request->search)){
			$search = $request->search;
		}
		

		/*
		 	@param getMessages 
		 	$search = null, $to_user = false, $start = 0, $limit = 0, $allConversation = true
		*/
		
		// Get the Conversations
		$result = Message::getMessages($search, false, $start, $limit, true);

		$data['conversations'] = $result['data'];
		$totalCount = $result['count'];
		

		
		if($totalCount <= $curentRecordCount){
			$data['is_last_page'] = 1;
			$data['pageNo'] = $pageNo;
		}else{
			$data['pageNo'] = $pageNo + 1;
		}
		
		// echo "<pre>"; print_r ($totalCount); echo "<br />"; echo $curentRecordCount; echo "</pre>"; exit();
		// $data['conversations'] = Message::getConversations(auth()->user()->id, $this->perPage, null);

		// Meta Tags
		MetaTag::set('title', t('Message Received - :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::set('description', t('Message Received on :app_name', ['app_name' => config('settings.app.name')]));

		CommonHelper::ogMeta();

		if ($request->ajax()) {
			 
			$returnHTML = view('messages-ajax' , $data)->render();
			return response()->json(array('success' => true, 'html'=> $returnHTML, 'pageNo' => $data['pageNo'], 'is_last_page' => $data['is_last_page']));
		}

		return view('messages', $data);
	}

	/**
	 * filter Conversations List
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function filter(Request $request) {
		$data = [];

		// Set the Page Path
		view()->share('pagePath', 'conversations');

		$search = !empty($request->input('search')) ? $request->input('search') : '';

		if ($search != '') {
			$data['conversations'] =Message::getConversations(auth()->user()->id, $this->perPage, null,$search);
		} else {
			$data['conversations'] = Message::getConversations(auth()->user()->id, $this->perPage, null);
		}

		// Meta Tags
		MetaTag::set('title', t('Conversations Received'));
		MetaTag::set('description', t('Conversations Received on :app_name', ['app_name' => config('settings.app.name')]));

		// return view('account.conversations', $data);

		return view('messages-ajax', $data);
	}

	public function personalchatindex() {
		$data = [];

		// Set the Page Path
		view()->share('pagePath', 'conversations');

		// Get the Conversations
		$data['conversations'] = $this->conversations->paginate($this->perPage);

		// Meta Tags
		MetaTag::set('title', t('Conversations Received'));
		MetaTag::set('description', t('Conversations Received on :app_name', ['app_name' => config('settings.app.name')]));

		return view('account.conversationspersonal', $data);
	}

	/**
	 * Conversation Messages List
	 *
	 * @param $conversationId
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function messages($conversationId, Request $request) {
		$data = [];

		$req = $request->all();
		$page = 1;

		if(isset($req) && isset($req['page'])){
			$page = $req['page'];
		}

		if (!Gate::allows('view_conversations', auth()->user())) {
            flash("You are not allow to access this page")->error();
			return redirect(config('app.locale'));
        }

		// Set the Page Path
		view()->share('pagePath', 'conversations');

		// Get the Conversation
		// $conversation = Message::with('post')->where('id', $conversationId)->where(function ($query) {
		// 	$query->where('to_user_id', auth()->user()->id)->orWhere('from_user_id', auth()->user()->id);
		// })
		// 	->where(function ($query) {
		// 		$query->where('deleted_by', '!=', auth()->user()->id)->orWhereNull('deleted_by');
		// 	})
		// 	->firstOrFail();

		if( isset($conversationId) && !empty($conversationId) ){



			$contact_name = '';
			$city_name = '';
			$country_name = '';
			$job_url = '';

			$getMessageType = Message::where('id', $conversationId)
									->WhereNull('deleted_at')
									->WhereNull('deleted_by')
									->select('message_type')
									->first();
			$direct_message = false;
			if($getMessageType->message_type == 'Direct Message'){
				$direct_message = true;
				$conversation = Message::with('convmessages')
									->where('id', $conversationId)
									->WhereNull('deleted_at')
									->WhereNull('deleted_by')
									->first();
			}else{
				$conversation = Message::with('post')
									->wherehas('post')
									->with('convmessages')
									->where('id', $conversationId)
									->WhereNull('deleted_at')
									->WhereNull('deleted_by')
									->first();
			}
			
			if(isset($conversation) && !empty($conversation)){

				//check selected conversation is belongs to logged in user or if not then redirect to messages page 
				if( $conversation->from_user_id != auth()->user()->id && $conversation->to_user_id != auth()->user()->id ){
					flash(t("Messages are not accessible to your profile"))->error();
					return redirect(lurl(trans('routes.messages')));
				}

				// check post is archived  then do not show the conversations
				if( isset($conversation) && isset($conversation->post) && $conversation->post->archived == 1 && $direct_message == false){
					flash(t('This job is no longer available'))->error();
					return redirect()->back();
				}

				// check post is deleted  then do not show the conversations
				if( isset($conversation) && empty($conversation->post) && $direct_message == false ){
					flash(t('This job is no longer available'))->error();
					return redirect()->back();
				}

				$data['profile_image'] = $data['profile_image_from'] = "";
				$data['is_operator'] = false;

				$data['from_user_name'] = $data['to_user_name'] =  $data['from_user_city'] = $data['to_user_city'] =  $data['from_user_country'] = $data['to_user_country'] = "";
				$data['is_direct_message'] = $direct_message;

				if (!empty($conversation)) {

					if($conversation->from_user_id){

						// $user_image = User::find($conversation->from_user_id);

						// $user_image = UserProfile::SELECT('logo','city')->where('user_id', $conversation->from_user_id)->first();

						$user_details = User::where('id', $conversation->from_user_id)->first();

						$data['profile_image'] = ($user_details->profile->logo)? $user_details->profile->logo : '';
						

						$user_city = ($user_details->profile->city)? $user_details->profile->city : '';
						$user_country = ($user_details->country_name)? $user_details->country_name : '';

						if (!empty($user_details)) {
							$data['from_user_name'] = $user_details->profile->full_name;

							if($user_details->user_type_id == config('constant.partner_type_id') && $conversation->message_type === 'invitation' && $user_details->is_operator == true){
								$data['is_operator'] = true;
							}
							
						}

						if(isset($user_country) && !empty($user_country)){
							$data['from_user_country'] = $user_country;
						}

						//$city = City::where('id', $user_city)->first();
						if (!empty($user_city)) {
							$city_name = explode(',', $user_city);
							$city_name = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $user_city;
							$data['from_user_city'] = $city_name;
						}

						// $country = Country::where('code', $user_country)->first();
						// if (!empty($country)) {
						// 	$data['from_user_country'] = $country['name'];
						// }

					}

					if($conversation->to_user_id){
						$to_user_details = User::where('id', $conversation->to_user_id)->first();

						// $to_user_image = UserProfile::SELECT('logo','city')->where('user_id', $conversation->to_user_id)->first();

						$data['profile_image_from'] = ($to_user_details->profile->logo)? $to_user_details->profile->logo : '';
						

						$user_city = ($to_user_details->profile->city)? $to_user_details->profile->city: '';

						$user_country = ($to_user_details->country_name)? $to_user_details->country_name: '';

						if (!empty($to_user_details)) {
							$data['to_user_name'] = $to_user_details->profile->full_name;

							if($to_user_details->user_type_id == config('constant.partner_type_id') && $conversation->message_type === 'Job application' && $to_user_details->is_operator == true){
								$data['is_operator'] = true;
							}
						}
						
						//$user_country = $user_image->country;
						//$city = City::where('id', $user_city)->first();
						
						if (!empty($user_city)) {
							
							$city_name = explode(',', $user_city);
							$city_name = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $user_city;
		 					$data['to_user_city'] = $city_name;
						}
						
						if (!empty($user_country)) {
							$data['to_user_country'] = $user_country;
						}

						// $country = Country::where('code', $user_country)->first();
						// if (!empty($country)) {
						// 	$data['to_user_country'] = $country['name'];
						// }
					}


					if (isset($conversation->post) && !empty($conversation->post)) {
						$post = $conversation->post;
						$contact_name = !empty($post->contact_name) ? $post->contact_name : '';
						$job_url = $post->uri;
						// commented city code
						// $city_id = $post->city_id;
						$country_code = $post->country_code;

						// $city = City::where('id', $city_id)->first();
						// if (!empty($city)) {
						// 	$city_name = $city['name'];
						// }
						if (!empty($post->city)) {
							$city_name = $post->city;
						}

						$country = Country::where('code', $country_code)->first();
						if (!empty($country)) {
							$country_name = $country['name'];
						}
					}
				}


				$data['contact_name'] = $contact_name;
				$data['city_name'] = $city_name;
				$data['country_name'] = $country_name;
				$data['job_url'] = $job_url;
				$data['conversation_id'] = $conversationId;

				view()->share('conversation', $conversation);
				
				// Get the Conversation's Messages
				// $data['messages'] = Message::where('parent_id', $conversation->id)->where(function ($query) {
				// 	$query->where('to_user_id', auth()->user()->id)->orWhere('from_user_id', auth()->user()->id);
				// })
				// 	->where(function ($query) {
				// 		$query->where('deleted_by', '!=', auth()->user()->id)->orWhereNull('deleted_by');
				// 	})
				// 	->orderByDesc('id');

				$total_reords = $total_pages = 0;
				$current_page = (isset($page))? $page : 1;
				$data['messages'] = (object) array();
				$data['countMessages'] = 0;
				if (!empty($conversation)) {
					$data['countMessages'] = $conversation->convmessages()->count();

					
					$total_reords = $conversation->convmessages()->count();
					$data['messages'] = $conversation->convmessages()->paginate($this->perPage)->reverse();
					
					//$data['messages'] =\App\Helpers\CommonHelper::geturlfromstring($data['messages']);
				}

				if( $total_reords > 0 ){
					$total_pages = ceil($total_reords / $this->perPage);
				}

				$data['is_last_page'] = ($current_page == $total_pages)? 1 : 0;
				$data['current_page'] = $current_page;
				$data['total_pages'] = $total_pages;
				
				$data['next_page'] = "";
					

				if($page != $total_pages){
					$data['next_page'] = ($current_page + 1);
				}


				if(isset($conversation->message_type) && ( $conversation->message_type == 'Invitation' || $conversation->message_type == 'Job application' || $conversation->message_type == 'Direct Message') ){
					// if ($data['countMessages'] > 0) {
					//Update is read 1 and is email 1
					$updateReadEmail = array(
						'is_read' => 1,
						'is_email_send' => 1,
					);
						//old update query
						// Message::where('parent_id', $conversation->id)->where('to_user_id', auth()->user()->id)->update(['is_read' => 1]);
					
						//New update query
						Message::where('parent_id', $conversation->id)->where('to_user_id', auth()->user()->id)->update($updateReadEmail);
					// }
				}

				
				$new_message = Message::where([
					['to_user_id', Auth::user()->id],
					['is_read', '0'],

				])->count();

				$data['new_message'] = $new_message;

				// Meta Tags
				MetaTag::set('title', t('Messages Received'));
				MetaTag::set('description', t('Messages Received on :app_name', ['app_name' => config('settings.app.name')]));

				// return view('account.messages', $data);

				if($request->ajax()){
	               	$returnHTML = view('message-texts-ajax' , $data)->render();
	  				
	  				return response()->json(
	  					array('success' => true, 'html'=> $returnHTML, 'is_last_page' => $data['is_last_page'], 'current_page' => $data['current_page'], 'next_page' => $data['next_page'] )
	  				);

	            }else{
					return view('message-texts', $data);
	            }
			

			}else{
				flash(t("Invalid Request Found"))->error();
				return redirect()->back();
			}

		} else {
			flash(t("Invalid Request Found"))->error();
			return redirect()->back();
		}

	
	}

	/**
	 * Conversation Message's job detail
	 *
	 * @param $conversationId
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function messagesJob($conversationId, $postId) {
		if( isset($conversationId) && !empty($conversationId) && isset($postId) && !empty($postId) )
		{
			$data = [];

			view()->share('pagePath', 'conversations');
			$conversation = Message::with('post')
										->wherehas('post')
										->with('convmessages')
										->where('id', $conversationId)
										->WhereNull('deleted_at')
										->WhereNull('deleted_by')
										->first();

			$data['conversation_id'] = $conversationId;

			view()->share('conversation', $conversation);

			// $prev_url = RequestFacade::server('HTTP_REFERER');

			// if(empty($prev_url)){

			// 	$prev_url = lurl(trans('routes.search', ['countryCode' => config('app.locale')]), ['countryCode' => config('app.locale')]);
			// }

			// session(['prev_url' => $prev_url]);

			// Get and Check the Controller's Method Parameters
			

			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])->where('id', $postId)->with(['user', 'pictures'])->first();

			$attr = ['countryCode' => config('app.locale')];

			if(empty($post)){
				//job does not exists. redirect back to job listing
				flash(t("This job is no longer available"))->error();
				return redirect(lurl(trans('routes.search', $attr), $attr));
			}

			if(isset($post) && $post->archived == 1 && $post->user_id != Auth::user()->id){
				//job does not exists. redirect back to job listing
				flash(t("This job is no longer available"))->error();
				return redirect(lurl(trans('routes.search', $attr), $attr));
			}

			$is_partner = 0;
			$is_invite_user = 0;

			if($post->user_id == Auth::user()->id){
				//post is added by logged in user
				$is_partner = 1;
			}

		 	if($is_partner == 0){

		 		$preSearch = app('App\Http\Controllers\Search\SearchController')->preSearchData('', '', $postId);

		        // Search
				$search = new Search($preSearch);
				$data = $search->fechAll();

				// Export Search Result
				$count = json_decode($data['count']);
				
				$user_id = Auth::user()->id;

				$is_invite_user = Message::where(function($query) use($user_id){
	                return $query->where('from_user_id', $user_id)
	                    ->orWhere('to_user_id', $user_id);
	            })->where('post_id', $postId)->count();

				if(isset($count->all)){
					if($count->all == 0 && $is_invite_user == 0){
						return back()->withErrors(['permission' => t("That job does not suite to your profile")]);
						// return abort(404);
					}
				}
		 	}

		 	$data['is_deleted'] = false;
		 	$data['application_is_closed'] = false;
	 		if(isset($post->end_application) && !empty($post->end_application) && $post->end_application != ""){

				$deadline_date=$post->end_application;

				if(strtotime($deadline_date) < strtotime(date('Y-m-d')))
				{	
					$data['application_is_closed'] = true;
					flash(trans('validation.application_is_closed'))->error();
				}
			}

			// GET POST'S DETAILS
			if (Auth::check()) {


				// If the logged user is not an admin user...
				if (Auth::user()->is_admin != 1) {
					// Then don't get post that are not from the user
					if (!empty($post) && $post->user_id != Auth::user()->id) {

						// If user is not invited then check the ismodel condition
						if(!$is_invite_user){

							if(Auth::user()->user_type_id == 3){
								if(isset($post->ismodel) && $post->ismodel == 0){
									return back()->withErrors(['permission' => t("That job does not suite to your profile")]);
								}
							}

							if(Auth::user()->user_type_id == 2){
								if(isset($post->ismodel) && $post->ismodel == 1){
									return back()->withErrors(['permission' => t("That job does not suite to your profile")]);
								}
							}
						}

					}
				}

				// Get the User's Resumes
				$limit = config('larapen.core.selectResumeInto', 5);
				$cacheId = 'resumes.take.' . $limit . '.where.user.' . Auth::user()->id;
				$resumes = Cache::remember($cacheId, $this->cacheExpiration, function () use ($limit) {
					$resumes = Resume::where('user_id', Auth::user()->id)->take($limit)->orderByDesc('id')->get();

					return $resumes;
				});
				view()->share('resumes', $resumes);

				// Get the User's latest Resume
				if ($resumes->has(0)) {
					$lastResume = $resumes->get(0);
					view()->share('lastResume', $lastResume);
				}
			} else {
				// $cacheId = 'post.with.user.city.pictures.' . $postId;
				// $post = Cache::remember($cacheId, $this->cacheExpiration, function () use ($postId) {
				// 	$post = Post::withTrashed()->where('id', $postId)->with(['user', 'pictures'])->first();

				// 	return $post;
				// });
				// $post = Post::withTrashed()->where('id', $postId)->with(['user', 'pictures'])->first();
			}



			// Post not found
			if (empty($post) && empty($post->city)) {
				// abort(404, t('Post not found'));
				return back()->withErrors(['error' => t("Post not found")]);
			}

			
			$post->preventAttrSet = true;
			$data['is_deleted'] = false;

			// check if post is archived or deleted then show the servie not availble message
			if ( $post->archived == 1 || $post->deleted_at != "" ) {
				flash(t("This job is no longer available"))->error();
				// check user is model or is a partner and not created user then redirect back  the page
				if( (Auth::user()->user_type_id == 2 && $post->user_id != Auth::user()->id) || Auth::user()->user_type_id == 3 ){
					return redirect()->back();
				}

				if($post->deleted_at != ""){
					$data['is_deleted'] = true;
				}
			}

			// Share post's details
			view()->share('post', $post);

			$property = [];

			$men_dress = '';
			$women_dress = '';
			$baby_dress = '';

			$men_shoe = '';
			$women_shoe = '';
			$baby_shoe = '';


			$is_dress_size = false;
			$is_shoe_size = false;
			
			 
			if($post->ismodel == 1){

				$validValues = ValidValue::all();

				foreach ($validValues as $val) {
					$translate = $val->getTranslation(app()->getLocale());
					$property[$val->type][$val->id] = $translate->value;
				}

				$unitArr = new UnitMeasurement(Auth::user()->country_code);
				$unitoptions = $unitArr->getUnit(true);

				$dress_Size = $unitArr->getDressSizeByPost();
				$shoe_Size = $unitArr->getShoeSizeByPost();

				$property = array_merge($property, $unitoptions);

				// get baby dress size
				if(!empty($post->dress_size_baby)){
					
					$dress_size_baby = explode(',', $post->dress_size_baby);

					if(count($dress_Size['baby_dress']) > 0){

						foreach ($dress_size_baby as $key => $val) {

							if(array_key_exists($val, $dress_Size['baby_dress'])){

								$baby_dress .= $dress_Size['baby_dress'][$val].', ';
							}
						}
					}
				}

				// dress men size array
				if(!empty($post->dress_size_men)){
					
					$dress_size_men = explode(',', $post->dress_size_men);

					if(count($dress_Size['men_dress']) > 0){

						foreach ($dress_size_men as $key => $val) {

							if(array_key_exists($val, $dress_Size['men_dress'])){

								$men_dress .= $dress_Size['men_dress'][$val].', ';
							}
						}
					}
				}

				// get women dress size
				if(!empty($post->dress_size_women)){
					
					$dress_size_women = explode(',', $post->dress_size_women);
					
					if(count($dress_Size['women_dress']) > 0){
						 
						foreach ($dress_size_women as $key => $val) {

							if(array_key_exists($val, $dress_Size['women_dress'])){

								$women_dress .= $dress_Size['women_dress'][$val].', ';
							}
						}
					}
				}

				if(!empty($baby_dress) || !empty($men_dress) || !empty($women_dress)){
					$is_dress_size = true;
				}

				// get baby shoe size
				if(!empty($post->shoe_size_baby)){
					
					$shoe_size_baby = explode(',', $post->shoe_size_baby);

					if(count($shoe_Size['baby_shoe']) > 0){

						foreach ($shoe_size_baby as $key => $val) {

							if(array_key_exists($val, $shoe_Size['baby_shoe'])){

								$baby_shoe .= $shoe_Size['baby_shoe'][$val].', ';
							}
						}
					}
				}

				if( empty($baby_shoe) ){
					$baby_shoe = t('All');
				}
				
				// get men shoe size
				if(!empty($post->shoe_size_men)){
					
					$shoe_size_men = explode(',', $post->shoe_size_men);

					if(count($shoe_Size['men_shoe']) > 0){

						foreach ($shoe_size_men as $key => $val) {

							if(array_key_exists($val, $shoe_Size['men_shoe'])){

								$men_shoe .= $shoe_Size['men_shoe'][$val].', ';
							}
						}
					}
				}

				if(empty($men_shoe) && ($post->gender_type_id == config('constant.gender_male') || $post->gender_type_id == config('constant.gender_both'))) {
					$men_shoe = t('All');
				}

				// get women shoe size
				if(!empty($post->shoe_size_women)){
					
					$shoe_size_women = explode(',', $post->shoe_size_women);

					if(count($shoe_Size['women_shoe']) > 0){

						foreach ($shoe_size_women as $key => $val) {

							if(array_key_exists($val, $shoe_Size['women_shoe'])){

								$women_shoe .= $shoe_Size['women_shoe'][$val].', ';
							}
						}
					}
				}
				if(empty($women_shoe) && ($post->gender_type_id == config('constant.gender_female') || $post->gender_type_id == config('constant.gender_both'))) {
					$women_shoe = t('All');
				}

				if(!empty($baby_shoe) || !empty($men_shoe) || !empty($women_shoe)){
					$is_shoe_size = true;
				}

				if ($post->height_from > 0 && $post->height_to > 0) {
					if (!empty($property['height'][$post->height_from]) && !empty($property['height'][$post->height_to])) {
						$data['height'] = $property['height'][$post->height_from] . ' - ' . $property['height'][$post->height_to];
					}
				}

				if (isset($post->weight_from) && $post->weight_from > 0 && isset($post->weight_to) && $post->weight_to > 0) {
					if (!empty($property['weight'][$post->weight_from]) && !empty($property['weight'][$post->weight_to])) {
						$data['weight'] = $property['weight'][$post->weight_from] . ' - ' . $property['weight'][$post->weight_to];
					}

				}

				if ($post->dressSize_from > 0 && $post->dressSize_to > 0) {
					if (!empty($property['dress_size'][$post->dressSize_from]) && !empty($property['dress_size'][$post->dressSize_to])) {
						$data['dressSize'] = $property['dress_size'][$post->dressSize_from] . ' - ' . $property['dress_size'][$post->dressSize_to];
					}
				}

				if ($post->age_from > 0 && $post->age_to > 0) {
					if (!empty($post->age_from) && !empty($post->age_to)) {
						$data['age'] = $post->age_from .' '. trans('global.years') . ' - ' . $post->age_to . ' '.trans('global.years');
					}
				}

				if($post->chest_from > 0 || $post->chest_to){
					$chest = '';

					if($post->chest_from > 0 ){
						$chest .= $post->chest_from;
					}

					if($post->chest_from > 0 && $post->chest_to > 0 ){
						$chest .= ' - '.$post->chest_to;
					}else{
						$chest .= $post->chest_to;
					}

					$data['chest'] = $chest;
				}

				if($post->waist_from > 0 || $post->waist_to){
					$waist = '';

					if($post->waist_from > 0 ){
						$waist .= $post->waist_from;
					}

					if($post->waist_from > 0 && $post->waist_to > 0 ){
						$waist .= ' - '.$post->waist_to;
					}else{
						$waist .= $post->waist_to;
					}

					$data['waist'] = $waist;
				}

				if($post->hips_from > 0 || $post->hips_to){
					$hips = '';

					if($post->hips_from > 0 ){
						$hips .= $post->hips_from;
					}

					if($post->hips_from > 0 && $post->hips_to > 0 ){
						$hips .= ' - '.$post->hips_to;
					}else{
						$hips .= $post->hips_to;
					}

					$data['hips'] = $hips;
				}

				if($post->shoeSize_from > 0 || $post->shoeSize_to){
					$shoeSize = '';

					if($post->shoeSize_from > 0 ){
						$shoeSize .= $post->shoeSize_from;
					}

					if($post->shoeSize_from > 0 && $post->shoeSize_to > 0 ){
						$shoeSize .= ' - '.$post->shoeSize_to;
					}else{
						$shoeSize .= $post->shoeSize_to;
					}

					$data['shoeSize'] = $shoeSize;
				}
			}

			$data['men_shoe'] = $men_shoe;
			$data['women_shoe'] = $women_shoe;
			$data['baby_shoe'] = $baby_shoe;

			$data['men_dress'] = $men_dress;
			$data['women_dress'] = $women_dress;
			$data['baby_dress'] = $baby_dress;

			$data['is_dress_size'] = $is_dress_size;
			$data['is_shoe_size'] = $is_shoe_size;
			
			// Get category details
			$getCategory = array();
			if(isset($post->category_id) && !empty($post->category_id)){
				$cat_ids = explode(',',$post->category_id);

				if(count($cat_ids) > 0 ){
					foreach ($cat_ids as $kid => $vid) {
						
						$cacheId = 'category.' . $vid . '.' . config('app.locale');
						$getCategory = Cache::remember($cacheId, $this->cacheExpiration, function () use ($vid) {
							$cat = Category::transById($vid);
							return $cat;
						});
						if(!empty($getCategory))
							$cat[] = $getCategory;
					}
				}
			}


			$data['properties'] = $property;

			// echo "<pre>"; print_r ($property); echo "</pre>"; exit();
			$experienceType = '';
			$experienceTypeDetail = ExperienceType::where('id', $post->experience_type_id)->first();
			if (!empty($experienceTypeDetail)) {
				$experienceType = $experienceTypeDetail->name;
			}
			view()->share('experienceType', $experienceType);

			view()->share('cat', $cat);
			
			// Get post type details
			$cacheId = 'postType.' . $post->post_type_id . '.' . config('app.locale');
			$postType = Cache::remember($cacheId, $this->cacheExpiration, function () use ($post) {
				$postType = PostType::transById($post->post_type_id);

				return $postType;
			});
			view()->share('postType', $postType);

			// Get the Post's Salary Type
			$cacheId = 'salaryType.' . $post->salary_type_id . '.' . config('app.locale');
			$salaryType = Cache::remember($cacheId, $this->cacheExpiration, function () use ($post) {
				$salaryType = SalaryType::transById($post->salary_type_id);

				return $salaryType;
			});
			view()->share('salaryType', $salaryType);

			// Require info
			
			if (empty($cat)) {
				$message = t("Something went wrong Please try again");
				if($post->user_id == Auth::user()->id){
					$message = t("Please update your job categories");
				}
				return back()->withErrors(['error' => $message]);
			}

			if (empty($postType)) {
				$message = t("Something went wrong Please try again");
				if($post->user_id == Auth::user()->id){
					$message = t("Please update your post type");
				}
				return back()->withErrors(['error' => $message]);
			}

			// Get package details
			$package = null;
			if ($post->featured == 1) {
				$payment = Payment::where('post_id', $post->id)->orderBy('id', 'DESC')->first();
				if (!empty($payment)) {
					$package = Package::transById($payment->package_id);
				}
			}
			view()->share('package', $package);

			// Get ad's user decision about comments activation
			$commentsAreDisabledByUser = false;
			// Get possible ad's user
			if (isset($post->user_id) && !empty($post->user_id)) {
				$possibleUser = User::find($post->user_id);
				if (!empty($possibleUser)) {
					if ($possibleUser->disable_comments == 1) {
						$commentsAreDisabledByUser = true;
					}
				}
			}
			view()->share('commentsAreDisabledByUser', $commentsAreDisabledByUser);

			// GET PARENT CATEGORY
			// if ($cat->parent_id == 0) {
			// 	$parentCat = $cat;
			// } else {
			// 	$parentCat = Category::transById($cat->parent_id);
			// }

			// if($parentCat == ''){
			// 	$parentCat = "";
			// }

			// view()->share('parentCat', $parentCat);

			// Increment Post visits counter
			Event::dispatch(new PostWasVisited($post));

			// GET SIMILAR POSTS
			// $featured = $this->getCategorySimilarPosts($cat, $post->id);
			// $featured = $this->getLocationSimilarPosts($post->city, $post->id);
			// $data['featured'] = $featured;

			// SEO
			$post_city = '';
			if(isset($post->city) && !empty($post->city)){
				$post_city = $post->city;
			}
			$title = $post->title . ', ' . $post_city;
			$description = str_limit(str_strip(strip_tags($post->description)), 200);

			// Meta Tags
			MetaTag::set('title', $title);
			MetaTag::set('description', $description);
			if (!empty($post->tags)) {
				MetaTag::set('keywords', str_replace(',', ', ', $post->tags));
			}

			// Open Graph
			$data['og_seo_tags'] = array(
								'og:title' => $title,
								'og:description' => $description,
								'og:type' => 'article',
								'og:image' => url('/images/logo-fb.png'),
								'og:image:alt' => config('app.app_name')
							);

			// Check post is expired or not
			$data['is_expired'] = false;

			if(isset($post->end_application) && !empty($post->end_application) && $post->deleted_at === "" && $post->archived == 0){
				
				$current_date = new \DateTime('Today');
				$expire_date = new \DateTime($post->end_application);

				
				if ($current_date > $expire_date) {
				   flash(t("Warning! This ad has expired, The product or service is not more available (may be)"))->error();
				   $data['is_expired'] = true;
				}
			}

			// Expiration Info
			$today_dt = Date::now(config('timezone.id'));
			// if ($today_dt->gt($post->created_at->addMonths($this->expireTime))) {
			// 	flash(t("Warning! This ad has expired, The product or service is not more available (may be)"))->error();
			// }



			$data['userCountry'] = CountryLocalization::getCountryNameByCode($post->user->country_code);

			// $data['is_applyed']

			// $JobApplicationCount = JobApplication::where('post_id', $post->id)->where('user_id', Auth::user()->id)->count();

			/*$data['is_applyed'] = Post::SELECT('posts.*')
	                ->leftjoin('job_applications', 'job_applications.post_id','posts.id')
	                ->where('job_applications.user_id', Auth::User()->id)
	                ->where('job_applications.post_id', $post->id)->count();*/


	        // check in message to user applied for job
	        $data['is_applyed'] = $data['userinvitaiton'] = '';

	        $is_applied = Message::where('post_id', $post->id)->where('from_user_id', Auth::User()->id)->where('message_type', 'Job application')->first();

	        $data['message_url'] = "";

	        if( isset($is_applied) && !empty($is_applied) && $is_applied->count() > 0){
	        	$data['is_applyed'] = 1;
	        	$data['message_url'] = lurl('account/conversations/'.$is_applied->id.'/messages');
	        }
			
			$userinvitaiton = Message::wherehas('post', function($query){
	                				$query->where('archived', 0);
	            				})
								->where('post_id', $post->id)
								->where('to_user_id', Auth::user()->id)
								->where('message_type','Invitation')
								->whereIn('invitation_status', ['0','1'])->first();

			$data['is_invited'] = 0;
			$data['invitation'] = "";

			if(isset($userinvitaiton) && !empty($userinvitaiton)){
				$data['is_invited'] = 1;
				$data['invitation'] = $userinvitaiton;

				// if invitation is accepted 
				if($userinvitaiton->invitation_status == 1){ 
					$data['message_url'] = lurl('account/conversations/'.$userinvitaiton->id.'/messages');
				}
			}

			$data['is_advertising'] = false;
			if (\App\Models\Advertising::where('slug', 'top')->count() > 0) {
				$data['is_advertising'] = true;
			}
			
			$is_save_Post = 0;
			 
			if($post->user_id != auth()->user()->id){
				$is_save_Post =  SavedPost::where('user_id', auth()->user()->id)->where('post_id', $post->id)->count();
			} 


			// Get Report abuse types
			$reportTypes = ReportType::trans()->get();
			$data['reportTypes'] = $reportTypes;
			$data['title'] = t('Report for :title', ['title' => ucfirst($post->title)]);
			$description = t('Send a report for :title', ['title' => ucfirst($post->title)]);

			$data['is_save_Post'] = $is_save_Post;
			// $data['is_contract_expire'] = $is_contract_expire;

			// View
			return view('message-job-detail', $data);
		}
		else
		{
			flash(t("Invalid Request Found"))->error();
		}
		
	
	}

	/**
	 * @param $conversationId
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function reply($conversationId, Request $request) {
		// Form validation

		// conversation url
		$conversation_url = url()->previous();
		$rules = ['message' => 'required|mb_between:1,1000'];
		//$this->validate($request, $rules);

		$validator = Validator::make($request->all(), $rules);

		// Validate the input and return correct response
		if ($validator->fails()) {
			return array('success' => false, 'message' => $validator->getMessageBag()->toArray()); exit();
		}

		// Get Conversation
		$conversation = Message::find($conversationId);

		if(isset($conversation) && !empty($conversation)){
			
			// Get Recipient Data
			
			if ($conversation->from_user_id != auth()->user()->id) {
				$toUserId = $conversation->from_user_id;
				$toName = $conversation->from_name;
				$toEmail = $conversation->from_email;
				$toPhone = $conversation->from_phone;
			} else {
				$toUserId = $conversation->to_user_id;
				$toName = $conversation->to_name;
				$toEmail = $conversation->to_email;
				$toPhone = $conversation->to_phone;
			}

			// Don't reply to deleted (or non exiting) users
			if (config('settings.single.guests_can_post_ads') != 1 && config('settings.single.guests_can_apply_jobs') != 1) {
				if (User::where('id', $toUserId)->count() <= 0) {
					flash(t("This user no longer exists") . ' ' . t("Maybe the user's account has been disabled or deleted."))->error();
					return back();
				}
			}

			$post_id = 0;
			$message_message = $request->input('message');

			if ($conversation->post) {
				$post_id = $conversation->post->id;
				$message_message = $request->input('message');
				// $message_message = $request->input('message')
				// . '<br><br>'
				// . t('Related to the ad')
				// . ': <a href="' . lurl($conversation->post->uri) . '">' . t('Click here to see') . '</a><br><a href="' . $conversation_url . '">' . t('click_here_for_replay') . '</a>';
			}

			// Store Reply Info
			$newMessage = [
				'post_id' => $post_id,
				'parent_id' => $conversation->id,
				'from_user_id' => auth()->user()->id,
				'from_name' => auth()->user()->name,
				'from_email' => auth()->user()->email,
				'from_phone' => auth()->user()->phone,
				'to_user_id' => $toUserId,
				'to_name' => $toName,
				'to_email' => $toEmail,
				'to_phone' => $toPhone,
				'subject' => 'RE: ' . $conversation->subject,
				'message' => $message_message,
				'message_type' => 'Conversation'
			];

			$message = new Message($newMessage);
			$message->save();

			// Save and Send user's resume
			if ($request->hasFile('filename')) {
				$message->filename = $request->file('filename');
				$message->save();
			}

			// Mark the Conversation as Unread
			if ($conversation->is_read != 0) {
				$conversation->is_read = 0;
				$conversation->save();
			}

			$date = \App\Helpers\CommonHelper::getFormatedDate($message->created_at, true);

			$pagination = false;
			$total_reords = $conversation->convmessages()->count();
			
			if( $total_reords > $this->perPage ){
				$pagination = true;
			}

			// Send Reply Email
			try {
				//$message->notify(new ReplySent($message));
				return array('status' => true, "message" => trans("Your reply has been sent, Thank you!"), 'messageId' => $message->id, 'msg' => \App\Helpers\CommonHelper::geturlfromstring($message_message), 'date' => $date, 'pagination' => $pagination); exit();
			} catch (\Exception $e) {
				return array('status' => false, "message" => $e->getMessage()); exit();
			}

		}else{
			return array('status' => false, "message" => trans('some error occurred')); exit();
		}
	}

	/**
	 * @param $conversationId
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function contact($conversationId, Request $request) {
		// Form validation
		$rules = ['message' => 'required|mb_between:20,500'];
		$this->validate($request, $rules);

		// Get Recipient Data
		$partner = User::find($conversationId);
		$toUserId = $partner->id;
		$toName = ($partner->profile->first_name)? $partner->profile->first_name : $partner->name;
		$toEmail = $partner->email;
		$toPhone = $partner->phone;

		// Don't reply to deleted (or non exiting) users
		if (config('settings.single.guests_can_post_ads') != 1 && config('settings.single.guests_can_apply_jobs') != 1) {
			if (User::where('id', $toUserId)->count() <= 0) {
				flash(t("This user no longer exists") . ' ' . t("Maybe the user's account has been disabled or deleted."))->error();
				return back();
			}
		}

		$Path = 'specials/' . auth()->user()->id;
		Storage::makeDirectory($Path);
		$destinationPath = 'uploads/' . $Path;
		$attach = $Path . '?';
		for ($i = 0; $i < 5; $i++) {
			$filename = 'special.filename' . $i;
			$file = $request->file($filename);
			if ($file) {
				$file->move($destinationPath, $file->getClientOriginalName());
				$attach .= 'img' . $i . '=' . $file->getClientOriginalName() . '&';
			}
		}

		$fromUser = auth()->user();
		// Store Reply Info
		$newMessage = [
			'from_user_id' => $fromUser->id,
			'from_name' => ($fromUser->profile->name)? $fromUser->profile->name : $fromUser->name,
			'from_email' => auth()->user()->email,
			'from_phone' => auth()->user()->phone,
			'to_user_id' => $toUserId,
			'to_name' => $toName,
			'to_email' => $toEmail,
			'to_phone' => $toPhone,
			'subject' => 'Contact From ' . auth()->user()->name,
			'message' => $request->input('message'),
			'filename' => lurl($attach),
		];
		$message = new Message($newMessage);
		$message->save();

		// Send Contact Email
		try {
			$message->notify(new ContactSent($message));
			flash(t("Your contact has been sent Thank you!"))->success();
		} catch (\Exception $e) {
			flash($e->getMessage())->error();
		}

		return back();
	}

	/**
	 * Delete Messages
	 *
	 * @param null $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	/*
	public function destroy($id = null) {
		// Get Entries ID
		$ids = [];
		if (RequestFacade::filled('entries')) {
			$ids = RequestFacade::input('entries');
		} else {
			if (!is_numeric($id) && $id <= 0) {
				$ids = [];
			} else {
				$ids[] = $id;
			}
		}

		// Delete
		$nb = 0;
		foreach ($ids as $id) {
			$message = Message::find($id);
			if (!empty($message)) {
				if (empty($message->deleted_by)) {
					// Delete the Entry for current user
					$message->deleted_by = auth()->user()->id;
					$message->save();
					$nb = 1;
				} else {
					// If the 2nd user delete the Entry,
					// Delete the Entry (definitely)
					if ($message->deleted_by != auth()->user()->id) {
						$nb = $message->delete();
					}
				}
			}
		}

		// Confirmation
		if ($nb == 0) {
			flash(t("No deletion is done, Please try again"))->error();
		} else {
			$count = count($ids);
			if ($count > 1) {
				flash(t("x :entities has been deleted successfully", ['entities' => t('messages'), 'count' => $count]))->success();
			} else {
				flash(t("1 :entity has been deleted successfully", ['entity' => t('message')]))->success();
			}
		}

		return back();
	}*/

	public function deleteMessages(Request $request) {
		$req = $request->all();

		if( isset($req) && !empty($req) && isset($req['msg_id'])){
			$messageId = $req['msg_id'];

			$message = Message::find($messageId);

			if( isset($message) && !empty($message) ){

				// Remove images if model applied for job and also send images in applications form
				if( isset($message->filename) && !empty($message->filename) ){
					$images = array();
					parse_str(parse_url($message->filename, PHP_URL_QUERY), $images);

					if( !empty($images) && count($images) > 0 ){
						$path = 'specials/' . Auth::user()->id;
						foreach ($images as $key => $img) {
							if (Storage::exists($path.'/'.$img)) {
								unlink(public_path('uploads/'.$path.'/'.$img));
							}
						}
					}
				}

				try{
					$message->delete();

					$pagination = false;
					if( isset($req['conversationId']) && !empty($req['conversationId']) ){
						$conversation = Message::where('id', $req['conversationId'])->first();
						$total_reords = $conversation->convmessages()->count();

						if( $total_reords > $this->perPage ){
							$pagination = true;
						}
					}

					return array('status' => true, "message" => trans('Message deleted successfully'), 'pagination' => $pagination); exit();

				}catch(\Exception $e){
					return array('status' => false, "message" => trans('some error occurred')); exit();
				}
				
			} else {
				return array('status' => false, "message" => trans('some error occurred')); exit();
			}
		}
	}

	public function destroysubmessage($id = null) {
		// Get Entries ID
		$ids = [];
		if (RequestFacade::filled('entries')) {
			$ids = RequestFacade::input('entries');
		} else {
			if (!is_numeric($id) && $id <= 0) {
				$ids = [];
			} else {
				$ids[] = $id;
			}
		}

		// Delete
		$nb = 0;
		foreach ($ids as $id) {
			$message = Message::find($id);
			if (!empty($message)) {
				if (empty($message->deleted_by)) {
					// Delete the Entry for current user
					$message->deleted_by = auth()->user()->id;
					$message->save();
					$nb = 1;
				} else {
					// If the 2nd user delete the Entry,
					// Delete the Entry (definitely)
					if ($message->deleted_by != auth()->user()->id) {
						$nb = $message->delete();
					}
				}
			}
		}

		// Confirmation
		if ($nb == 0) {
			flash(t("No deletion is done, Please try again"))->error();
		} else {
			$count = count($ids);
			if ($count > 1) {
				flash(t("x :entities has been deleted successfully", ['entities' => t('messages'), 'count' => $count]))->success();
			} else {
				flash(t("1 :entity has been deleted successfully", ['entity' => t('message')]))->success();
			}
		}

		return back();
	}

	

	/*
	    status : 0 = Invited,
	    status : 1 = Accepted,
	    status : 2 = Rejected,
	    status : 3 = All
    */
	public function getnotification($status = null, Request $request) {
		
		if (auth()->user()->user_type_id == config('constant.model_type_id') && !Gate::allows('list_invitations', auth()->user())) {
            flash("You are not allow to access this page")->error();
			return redirect(config('app.locale'));
        }elseif (auth()->user()->user_type_id == config('constant.model_type_id') && Gate::allows('view_invitation_page', auth()->user())) {
        	return $this->showInvitationPage();
        }

        
		// Records serch on notification pages with ajax request
		$search = ($request->search)? $request->search : '';

		// if($request->ajax()){
		// 	$search = $request->text;
		// }

		$slug = '';

		if($status != null){

			if($status == strtolower(t('Invited'))){
				$status = 0;
				$slug = 'Invited';
			}else if ($status == strtolower(t('Accepted'))) {
				$status = 1;
				$slug = 'Accepted';
			}else if($status == strtolower(t('Rejected'))){
				$status = 2;
				$slug = 'Rejected';
			}else{
				$status = 3;
			}
		}else{
			$status = 3;
		}

		$status = (string)$status;

		if(!empty($slug)){
			view()->share('notifications_slug', $slug);
		}

		$result = array();
	 	$invited_count = 0;
	 	$accepted_count = 0;
	 	$rejected_count = 0;
	 	
	 	$perPage = 12; 

	 	$result = $this->getnotificationByUser($status, Auth::user()->user_type_id, $search, $perPage);

		if(isset($result['invited_count'])){
			$invited_count = $result['invited_count'];
		}
		if(isset($result['accepted_count'])){
			$accepted_count = $result['accepted_count'];
		}
		if(isset($result['rejected_count'])){
			$rejected_count = $result['rejected_count'];
		}
		if(isset($result['notifications_count'])){
			$notifications_count = $result['notifications_count'];
		}

		$data['total_invited'] = $invited_count;
		$data['total_accepted'] = $accepted_count;
		$data['total_rejected'] = $rejected_count;
		$data['total_notifications'] = $notifications_count;
		$data['notifications'] = $result['notifications'];
		$data['paginator'] = $result['notifications'];
		$data['user_type'] = Auth::user()->user_type_id;
		$data['status'] = $status;
		$data['slug'] = $slug;
		$data['search'] = $search;

		// if($request->ajax()){

		// 	if(count($data['notifications']) > 0 ){
		// 		$returnHTML = view('notifications-ajax' , $data)->render();
		// 		return response()->json(array('success' => true, 'html'=> $returnHTML));
		// 	}
		// 	return response()->json(array('success' => false, 'html'=> ''));
		// }

		return view('notifications', $data);
	}


	public function getnotificationByUser($status, $user_type, $search, $perPage = 12){


		$notifications = Message::select('messages.*','jobs_translation.title','jobs_translation.description', 'users.user_type_id')
						// ->wherehas('post', function($query){
			   //              $query->where('archived', 0);
			   //          })
						->join('users', 'users.id', '=', 'messages.from_user_id')
						->join('users as u', 'u.id', '=', 'messages.to_user_id')
 						->join('posts', 'posts.id', '=', 'messages.post_id')
						->join('jobs_translation', function($query){
			                $query->on('posts.id', '=', 'jobs_translation.job_id');
			                $query->where('translation_lang', config('app.locale'));
						})

 						->where('posts.archived', 0)
 						->whereNull('u.deleted_at')
 						->whereNull('users.deleted_at')
						->where(function($query) use($user_type){
 							if($user_type == 2){
 								$query->where('from_user_id', Auth::user()->id);
 							}else{
 								$query->where('to_user_id', Auth::user()->id);
 							}
 						})->where('message_type', 'Invitation');

		if($search != ""){
			$notifications = $notifications->Where(function ($query) use ($search) {
				    	$query->where('jobs_translation.title', 'like', '%'.trim($search).'%')
					    ->orWhere('message', 'like', '%'.trim($search).'%')
					    ->orWhere('jobs_translation.description', 'like', '%'.trim($search).'%');
					});
		}

		if($status == 0 || $status == 1 || $status == 2){
			$status = strval($status);
			$notifications = $notifications->Where('invitation_status','=', (string)$status);
		}
		
		$notifications = $notifications->orderByDesc('messages.id')->paginate($perPage);


		if($notifications->total() > 0 ) 
		{
			foreach ($notifications as $key => $value) {

				$notifications[$key]->uri = ($value->post->uri)? $value->post->uri : '';

				
				$notifications[$key]->profile_pic = $notifications[$key]->to_profile_pic = "";
					
				if(isset($value->post->user->profile->logo) && !empty($value->post->user->profile->logo)){
					$notifications[$key]->profile_pic = \Storage::url($value->post->user->profile->logo);
				}

				if(isset($value->to_user->profile->logo) && !empty($value->to_user->profile->logo)){
					$notifications[$key]->to_profile_pic = \Storage::url($value->to_user->profile->logo);
				}

				if($user_type == 2){
					$notifications[$key]->name = $value->to_name;
				}else{
					$notifications[$key]->name = $value->from_name;
				}

			}
		}

		/*if($user_type == 2){
			$notifications = Message::select('messages.*','posts.title','posts.description','users.user_type_id')
							->wherehas('post', function($query){
				                $query->where('archived', 0);
				            })
							->join('users', 'users.id', '=', 'messages.from_user_id')
	 						->join('posts', 'posts.id', '=', 'messages.post_id')
							->where('from_user_id', Auth::user()->id)
							->where('message_type', 'Invitation');

			if($search != ""){
				$notifications = $notifications->Where(function ($query) use ($search) {
					    	$query->where('title', 'like', '%' . trim($search) . '%')
						    ->orWhere('message', 'like', '%' . trim($search) . '%');
						});
			}
			
			$notifications = $notifications->orderByDesc('messages.id')->get();

		}else{

			$notifications = Message::select('messages.*','posts.title','posts.description','users.user_type_id')
							->wherehas('post', function($query){
				                $query->where('archived', 0);
				            })
							->join('users', 'users.id', '=', 'messages.to_user_id')
	 						->join('posts', 'posts.id', '=', 'messages.post_id')
							->where('to_user_id', Auth::user()->id)
							->where('message_type', 'Invitation');

			if($search != ""){
				$notifications = $notifications->Where(function ($query) use ($search) {
					    	$query->where('title', 'like', '%' . trim($search) . '%')
						    ->orWhere('message', 'like', '%' . trim($search) . '%');
						});
			}

			$notifications = $notifications->orderByDesc('messages.id')->get();
		}*/


		$messageArr = array();
		$messageArr['notifications'] = $notifications;
	 	$messageArr['invited_count'] = 0;
	 	$messageArr['accepted_count'] = 0;
	 	$messageArr['rejected_count'] = 0;
	 	$messageArr['notifications_count'] = 0;
		

		$invited_count = 0;
		$accepted_count = 0;
		$rejected_count = 0;
		$notifications_count = 0;

		$user = Auth()->user();

		if(!empty($user)){

			if($user->userPostConversation && count($user->userPostConversation) > 0){
				
				foreach ($user->userPostConversation as $value) {
					
					if($value['invitation_status'] == 0 && $value['message_type'] == 'Invitation'){
				 		$messageArr['invited_count'] = $invited_count + 1;
				 		$invited_count++;

				 		$messageArr['notifications_count'] = $notifications_count + 1;
				 		$notifications_count++;
					}else if ($value['invitation_status'] == 1 && $value['message_type'] == 'Invitation') {

				 		// if($user_type != config('constant.partner_type_id') && $value->from_user_id != $user->id){
				 			
				 			$messageArr['accepted_count'] = $accepted_count + 1;
				 			$accepted_count++;

				 			$messageArr['notifications_count'] = $notifications_count + 1;
				 			$notifications_count++;
				 		// }
					}else if ($value['invitation_status'] == 2 && $value['message_type'] == 'Invitation') {
				 		$messageArr['rejected_count'] = $rejected_count + 1;
				 		$rejected_count++;

				 		$messageArr['notifications_count'] = $notifications_count + 1;
				 		$notifications_count++;
				 	}
				}
				
				// $messageArr['notifications_count'] = count($user->userPostConversation);
			}

		}

		 // echo "<pre>";  print_r($messageArr);  "</pre>"; exit(); 

		return $messageArr;
	}
	
	public function getsearchnotification(Request $request) {
		
		$notifications = array();
		$status = 3;
		$statusValue = '';
		$text = '';

		if(Auth::user()->user_type_id == 2){
		 	$user = 'from_user_id';
		}else{
			$user = 'to_user_id';
		}

		if(RequestFacade::filled('status') && !empty($request->input('status'))){
			$statusValue = $request->input('status');
		}

		if(!empty($statusValue)){

	 		if($statusValue == 'Invited'){
				$status = 0;
			}else if ($statusValue == 'Accepted') {
				$status = 1;
			}else if($statusValue == 'Rejected'){
				$status = 2;
			}
		}
		
		if(RequestFacade::filled('text') && !empty($request->input('text'))){
		 	$text = $request->input('text');
		}	
		
		$notifications = Message::select('messages.*','posts.title','posts.description','users.user_type_id')
			->join('users', 'users.id', '=', 'messages.'.$user)
			->join('posts', 'posts.id', '=', 'messages.post_id')
			->where($user , Auth::user()->id)
			->where('message_type', 'Invitation')
			->where('posts.archived', 0);

			if($status != 3){
				$notifications->where('invitation_status', (string)$status);
			}
				
			if(!empty($text)){
				$notifications->Where(function ($query) use ($text) {
					    	$query->where('title', 'like', '%' . trim($text) . '%')
						          ->orWhere('message', 'like', '%' . trim($text) . '%');
						});
			}
	 	$result = $notifications->orderByDesc('messages.id')->get();
		
		return response()->json($result);
	}

	public function approve(Request $request) {

		if (Auth::User() && Auth::User()->user_type_id != 3) {
			// check permission to allow only for model
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		
		$inviatation_status = '0';

		if ($request->status == '1') {
			$inviatation_status = '1';
			$invt_msg = trans("You have accepted the invitation");
		} else {
			$inviatation_status = '2';
			$invt_msg = trans("You have rejected the invitation");
		}

		$model_id = auth()->user()->id;

		if (\Auth::check() && isset($model_id)) {

			$message = Message::find($request->id);

			if ($message) {
				
				// If invitation is pending then update the inviation status
				if($message->invitation_status == 0){

					$message->invitation_status = $inviatation_status;
					$message->save();

					if ($message) {
						$data = [];
						$data['partner_name'] = $message->from_name;
						$data['partner_email'] = $message->from_email;
						$data['model_name'] = Auth::user()->name;
						$data['username'] = Auth::user()->username;
						$data['model_email'] = Auth::user()->email;
						$data['model_id'] = Auth::user()->id;
						$data['message'] = $message->post_id;
						$data['messageid'] = $message->id;
					}
					
					// if model acepted the invitation then make entry for job appliation table
					if ($request->status == '1') {

						if(isset($message->id) && $message->id != ""){
							$jobApplication = New JobApplication();
							$jobApplication->post_id = $message->post_id;
							$jobApplication->user_id = Auth::check() ? Auth::user()->id : 0;
							$jobApplication->status = 1;
							$jobApplication->save();
						}

						Mail::send(new InvitationAccepted($data));
					}
					
					// check request is ajax 
					if($request->ajax()){
						if($message->invitation_status === '1'){
							
							$msg = t('You have accepted the invitation');

							$url = lurl('account/conversations/'.$message->id.'/messages');
							

							//$msg .= '<br /><a href="'.$url.'" style="text-decoration: underline !important">'.t('click here').'</a> '.t('to view or send a message');
							
							return array('status' => true, 'msg' => $msg,'url' => $url,'invitation_status' => $message->invitation_status); exit();

						}else{

							$msg = t('You have rejected the invitation');

			            	return array('status' => true, 'msg' => $msg, 'invitation_status' => $message->invitation_status); exit();
						}

			        }else{

						flash($invt_msg)->success();

			        	if( isset($message->post->uri) && !empty($message->post->uri) ){
			        		return redirect(lurl($message->post->uri));
			        	}else{
							return redirect(lurl($message->post->uri));
			        	}
			        }

				}else{
					
					if($message->invitation_status === '1'){
						
						$msg = t('Invitation already accepted');

						$url = lurl('account/conversations/'.$message->id.'/messages');
						
						$msg .= '<br />'.t('For messages') . ' <a href="'.$url.'">'.t('click here').'</a>';
						
						return array('status' => true, 'msg' => $msg, 'invitation_status' => $message->invitation_status); exit();

					}else{

						$msg = t('Invitation already rejected');

		            	return array('status' => false, 'msg' => $msg, 'invitation_status' => $message->invitation_status); exit();
					}
				}

			}else{

				if($request->ajax()){
					return array('status' => false, 'msg' => t('Something went wrong Please try again'), 'invitation_status' => 0); exit();
				}
			}
		}



		// $message_data = Message::where('id', $request->id)->first();
		// $putdata = array(
		// 	'invitation_status' => '0',
		// );
		// $tableupdate = Message::where('id', $request->id)->update($putdata);

		//$message = Message::find($request->id);
		// if (!empty($message)) {
		// 	if (empty($message->deleted_by)) {
		// 		// Delete the Entry for current user
		// 		$message->deleted_by = auth()->user()->id;
		// 		$message->save();
		// 		$nb = 1;
		// 	} else {
		// 		// If the 2nd user delete the Entry,
		// 		// Delete the Entry (definitely)
		// 		if ($message->deleted_by != auth()->user()->id) {
		// 			$nb = $message->delete();
		// 		}
		// 	}
		// }

		//$partnerdata = User::where('id', $message_data['from_user_id'])->select('id', 'name', 'email', 'phone')->first();

		// $newMessage = [
		// 	'post_id' => $request->jobid,
		// 	'parent_id' => '0',
		// 	'from_user_id' => Auth::user()->id,
		// 	'from_name' => Auth::user()->name,
		// 	'from_email' => Auth::user()->email,
		// 	'from_phone' => Auth::user()->phone,
		// 	'to_user_id' => $partnerdata['id'],
		// 	'to_name' => $partnerdata['name'],
		// 	'to_email' => $partnerdata['email'],
		// 	'to_phone' => $partnerdata['phone'],
		// 	'subject' => trans('mail.Start_Conversation'),
		// 	'message' => $message,
		// 	'invitation_status' => '0',
		// ];

		// $message = new Message($newMessage);
		// $message->save();

		// if ($message) {
		// 	$data = [];
		// 	$data['partner_name'] = $partnerdata['name'];
		// 	$data['partner_email'] = $partnerdata['email'];
		// 	$data['model_name'] = Auth::user()->name;
		// 	$data['model_email'] = Auth::user()->email;
		// 	$data['model_id'] = Auth::user()->id;
		// 	$data['message'] = $request->jobid;
		// 	$data['messageid'] = $message->id;

		// 	Mail::send(new InvitationAccepted($data));

		// 	// return \Redirect::away('/account/conversations/' . $message->id . '/messages');
		// 	return \Redirect::back();
		// }

	}

	public function invitation(Request $request) {

		$req = $request->all();

		if (isset($req['jobid']) && isset($req['modelid'])) {

			$token = str_random(40);
			$postdata = Post::where('id', $request->jobid)->select('id')->first();

			if (!$postdata) {
				echo json_encode([
					'success' => false,
					'message' => t('Selected job not found'),
				]);exit();
			}

			$modeldata = User::where('id', $request->modelid)->first();

			$is_record_exist = Message::where('from_user_id', Auth::user()->id)
				->where('to_user_id', $req['modelid'])
				->where('post_id', $req['jobid'])
				->whereNull('deleted_at')
				->select('*')
				->first();

			$is_already_applied = Post::SELECT('posts.*')
                ->leftjoin('job_applications', 'job_applications.post_id','posts.id')
                ->where('job_applications.user_id', $req['modelid'])
                ->where('job_applications.post_id', $req['jobid'])->count();

            if($is_already_applied > 0 ){
            	$reject_msg = t('Model has already applied for this job');
            	echo json_encode(['success' => false,'message' => $reject_msg]);
            	exit();
            }

			if (!empty($is_record_exist)) {

				if ($is_record_exist->invitation_status === '1') {
					$reject_msg = t('Model has already accepted the invitation for this job');
				} else if ($is_record_exist->invitation_status === '2') {
					$reject_msg = t('Model has rejected the invitation for this job');
				} else {
					$reject_msg = t('You have already send the inviation for this job');
				}

				echo json_encode([
					'success' => false,
					'message' => $reject_msg,
				]);exit();
			}
			// }
			
			$newMessage = [
				'post_id' => $request->jobid,
				'parent_id' => '0',
				'from_user_id' => Auth::user()->id,
				'from_name' => 	(Auth()->user()->profile->first_name)? Auth()->user()->profile->first_name : Auth()->user()->name,
				'from_email' => Auth::user()->email,
				'from_phone' => Auth::user()->phone,
				'to_user_id' => $modeldata->id,
				'to_name' => 	$modeldata->profile->first_name,
				'to_email' => 	$modeldata->email,
				'to_phone' => 	$modeldata->phone,
				'subject' => trans('mail.partner_invite_you_for_Job'),
				'invitation_status' => '0',
				'message_type' => 'Invitation'
			];

			$message = new Message($newMessage);
			$message->save();

			//create entry in job_applications table while partner send inviation
			// if(isset($message->id) && $message->id != ""){
			// 	$jobApplication = New JobApplication();
			// 	$jobApplication->post_id = $message->post_id;
			// 	$jobApplication->user_id = Auth::check() ? Auth::user()->id : 0;
			// 	$jobApplication->status = 0;
			// 	$jobApplication->save();
			// }

			$lastInsert_id = $message->id;
			
			$message = '<h3>' . Auth::user()->name . '&nbsp' . trans("mail.has_invited_you_for_the_job") . '&nbsp"' . $postdata->title . '"' . '  </h3><br><a href="' . "/account/invtresp/1/" . $lastInsert_id . '"class="btn btn-primary">' . trans("mail.Approve") . '</a>&nbsp<a href="' . "/account/invtresp/2/" . $lastInsert_id . '" class="btn btn-danger">' . trans("mail.delete") . '</a>';

			$messageobj = Message::find($lastInsert_id);

			$messageobj->message = $message;
			$messageobj->update();

			$data = [];
			$getmodel = User::where('id', $request->modelid)->first();

			// $postdata = Post::where('id', $request->jobid)->select('id')->first();
			
			$data['partner_id'] = 	Auth::user()->id;
			$data['partner_name'] = Auth::user()->name;
			$data['model_id'] = 	$request->modelid;
			$data['model_name'] = 	$getmodel->profile->first_name;
			$data['model_email'] = $getmodel->email;
			$data['job_id'] = $request->jobid;
			$data['job_name'] = $postdata->title;
			$data['token'] = $token;
			$data['username'] = Auth::user()->username;

			$data['messageid'] = $messageobj->id;

			$data['accept_url'] = '<a href="'.url("/account/invtresp/1/$messageobj->id").'">'.trans('mail.to_accept').'</a>';
			$data['reject_url'] = '<a href="'.url("/account/invtresp/2/$messageobj->id").'">'.trans('mail.to_reject').'</a>';

			try{
				Mail::send(new InviteEmail($data));
            }
            catch(\Exception $e){
              echo json_encode(['success' => false,'message' => $e->getMessage()]); exit();
            }

			echo json_encode([
				'success' => true,
				'message' => t('Invitation send successfully'),
			]);exit();

		} else {
			echo json_encode([
				'success' => false,
				'message' => t('Invalid Request Found'),
			]);exit();
		}

		// return (t('invitation send'));

	}
	//Send email for unread massge in 15 minutes
	public function sendMessagesNotification(){

		//\Log::info("====== Laravel crone call with send crone email for unread messages ======");
		$data=array();
		$token = str_random(40);
		$newTime = strtotime('-15 minutes');
		$diff_date_time = date('Y-m-d H:i:s', $newTime);
		$curr_date_time = date('Y-m-d H:i:s');
		
		//Fetch data from join of massage and usertable
		//Change query to send last massage
		$conversation=DB::table('messages')
		    ->select('messages.*','users.email','jobs_translation.title','m2.idUpdate')
		    ->join(DB::raw('(SELECT  GROUP_CONCAT(id) as idUpdate,MAX(id) AS maxid,message_type,is_email_send
		                     FROM messages WHERE is_email_send = 0 GROUP BY post_id) m2'), function($join)
		        {
		            $join->on('messages.id', '=', 'm2.maxid');
		        })
		    ->join('posts', 'posts.id', '=', 'messages.post_id','left')
		    ->join('users', 'users.id', '=', 'messages.to_user_id','left')
		    ->join('jobs_translation', 'jobs_translation.job_id', '=', 'posts.id', 'left')
		    ->where('users.last_login_at', '<' ,$diff_date_time)	
		    ->where('messages.message_type','Conversation')
 			->where('messages.is_email_send','0')
 			->where('jobs_translation.translation_lang', config('app.locale'))
 			->whereNull('users.deleted_at')
		    ->orderBy('messages.id', 'DESC');

		    // $conversation=$conversation->where(function ($query) {
      //               $query->whereNotNull('messages.to_user_id')
      //                     ->Where('messages.to_user_id',"!=", '');
      //           });



		    $conversation=$conversation->get();
		/*
		$conversation = Message::select('messages.*','users.email','posts.title')
						->join('users', 'users.id', '=', 'messages.to_user_details','left')
						//post titel send in email
						->join('posts', 'posts.id', '=', 'messages.post_id','left')
 						->where('messages.is_read', 0)
 						->where('users.last_login_at', '<' ,$diff_date_time)	
 						// ->where('users.verified_email', '1') 	
 						// ->where('users.last_login_at', '=>' ,$diff_date_time)					
 						// ->where('users.last_login_at', '<=' ,$curr_date_time) 					
 						->where('message_type','Conversation')
 						->where('messages.is_email','0')
 						->orderBy('messages.id', 'DESC')
 						->get();
 						*/

 		$conversation_id = '';			
 		if(isset($conversation) && $conversation!='' && count($conversation) >0){
 			$is_error = false;
 			foreach($conversation as $conversationKey => $conversationValue){

 				if(isset($conversation_id) && $conversation_id!=''){
 					$conversation_id .=',';
 				}
 				$conversation_id .= $conversationValue->idUpdate;

 				$data['messageid']=$conversationValue->parent_id;
 				$data['from_name']= $conversationValue->from_name;
 				$data['from_email'] = $conversationValue->from_email;
 				$data['to_email'] = $conversationValue->to_email;
 				$data['to_name'] = $conversationValue->to_name;
 				$data['message'] = $conversationValue->message;
 				$data['subject'] = $conversationValue->subject;
 				$data['token'] = $token;
 				//post titel
 				$data['jobtitel']=$conversationValue->title;
 				
 				\Log::info('Job Title',['jobtitel' => $data['jobtitel']]);

 				try{
					Mail::send(new MassgaeEmailSent($data));
	            }
	            catch(\Exception $e){
	            	$is_error = true;
	    	        \Log::info('Error to send email', ['Response get status Code' => $e->getMessage()]);
		          	echo json_encode(['success' => false, 'message' => $e->getMessage()]);exit();
	            }	            
 			}

 			// conversation id update ie email send 1 
 			$idArr=explode(',',$conversation_id);

            if(isset($idArr) && $idArr!='' && count($idArr) > 0 ){
            	
            	try{
					Message::whereIn('id', $idArr)->update(['is_email_send' => '1']);
	            }
	            catch(\Exception $e){
	            	$is_error = true;
	    	        \Log::info('Error on update is_email_send', ['Error' => $e->getMessage()]);
		          	echo json_encode(['success' => false, 'message' => $e->getMessage()]);exit();
	            }	
            }


            if($is_error){
            	echo json_encode(['success' => false, 'message' => 'Error while unread messages email']);exit();
            }else{
            	echo json_encode(['success' => true, 'message' => 'Email send successfully']);exit();
            }

 		}else{
 			//\Log::info('Messages not found', ['info' => 'Unread messages not found']);
 			echo json_encode(['success' => true, 'message' => 'Unread messages not found']);exit();
 		}
	}

	public function showMessagePage(){

		// Get the Page
		$page = Page::where('slug', 'messages')->trans()->first();

		view()->share('page', $page);
		view()->share('uriPathPageSlug', 'messages');

		// Check if an external link is available
		if (!empty($page->external_link)) {
			return headerLocation($page->external_link);
		}

		$tags = getAllMetaTagsForPage($page->slug);
        $title = isset($tags['title']) ? $tags['title'] : '';
        $description = isset($tags['description']) ? $tags['description'] : '';
        $keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        MetaTag::set('keywords', $keywords);

		// CommonHelper::ogMeta();
		return view('pages.messages-page');
	}

	public function showInvitationPage(){

		// Get the Page
		$page = Page::where('slug', 'inviation')->trans()->first();

		view()->share('page', $page);
		view()->share('uriPathPageSlug', 'inviation');

		// Check if an external link is available
		if (!empty($page->external_link)) {
			return headerLocation($page->external_link);
		}

		$tags = getAllMetaTagsForPage($page->slug);
        $title = isset($tags['title']) ? $tags['title'] : '';
        $description = isset($tags['description']) ? $tags['description'] : '';
        $keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        MetaTag::set('keywords', $keywords);

		// CommonHelper::ogMeta();
		return view('pages.invitation-page');
	}


	//Send message
	public function directMessage(Request $request){
		
		$rules = ['message' => 'required|mb_between:1,1000'];
		$validator = Validator::make($request->all(), $rules);

		// Validate the input and return correct response
		if ($validator->fails()) {
			return array('success' => false, 'message' => $validator->getMessageBag()->toArray()); exit();
		}
		
		// $is_record_exist = Message::where('message_type', 'Direct Message')
		// 		->whereNull('deleted_at')
		// 		->where(function ($query) {
  //                   $query->where('messages.to_user_id', Auth::user()->id)->orWhere('messages.from_user_id', Auth::user()->id);
  //               })
		// 		->select('*')
		// 		->first();
		$to_user = $request->to_user_id;
		$is_record_exist = Message::where('message_type', 'Direct Message')
				->whereNull('deleted_at')
				->where(function ($query) use( $to_user ){
					$query->where(function ($q) use( $to_user ){
                    	$q->where('messages.to_user_id', $to_user)->Where('messages.from_user_id', Auth::user()->id);
	                    $q->orwhere('messages.to_user_id', Auth::user()->id)->Where('messages.from_user_id', $to_user);
					});
                })
				->select('*')
				->first();

		$from_name = (Auth()->user()->profile->first_name)? Auth()->user()->profile->first_name : Auth()->user()->name;
		if (empty($is_record_exist)) {

			$newMessage = [
				'parent_id' => '0',
				'from_user_id' => Auth::user()->id,
				'from_name' => 	(Auth()->user()->profile->first_name)? Auth()->user()->profile->first_name : Auth()->user()->name,
				'from_email' => Auth::user()->email,
				'from_phone_code' => Auth::user()->phone_code,
				'from_phone' => Auth::user()->phone,
				'to_user_id' => $request->to_user_id,
				'to_name' => 	$request->to_user_name,
				'to_phone_code' => $request->to_user_phone_code,
				'to_email' => 	$request->to_user_email,
				'to_phone' => 	$request->to_user_phone,
				'subject' => 	t('Message from :user_name', ['user_name' => $from_name]),
				'invitation_status' => '0',
				'message_type' => 'Direct Message'
			];
			$message = new Message($newMessage);
			$message->save();
			$parent_id = $message->id;

			
			

		}else{
			$parent_id = $is_record_exist->id;
		}
		
		$conversation = [
			'parent_id' => $parent_id,
			'from_user_id' => Auth::user()->id,
			'from_name' => 	$from_name,
			'from_email' => Auth::user()->email,
			'from_phone_code' => Auth::user()->phone_code,
			'from_phone' => Auth::user()->phone,
			'to_user_id' => $request->to_user_id,
			'to_name' => 	$request->to_user_name,
			'to_phone_code' => $request->to_user_phone_code,
			'to_email' => 	$request->to_user_email,
			'to_phone' => 	$request->to_user_phone,
			'subject' => t('Message from :user_name', ['user_name' => $from_name]),
			'invitation_status' => '0',
			'message_type' => 'Conversation',
			'message' => $request->message,
		];
		$message = new Message($conversation);
		$message->save();

		

		if(empty($is_record_exist)){
			//send direct message notifications
			try {
				$message->notify(new DirectMessage($message));
			} catch (\Exception $e) {
				 echo "<pre>"; print_r($e->getMessage()); echo "</pre>"; exit(); 
			}
		}

		
		return Response::json(array(
			'success' => true,
			'message' => t('Your message has sent successfully'),
		));
	}	
}
