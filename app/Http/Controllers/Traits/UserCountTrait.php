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

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\Traits\LocalizationTrait;
use App\Http\Controllers\Traits\RobotsTxtTrait;
use App\Http\Controllers\Traits\SettingsTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Post;
use App\Models\Page;
use App\Models\UserType;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Models\Country;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Silber\PageCache\Middleware\CacheResponse;
use Illuminate\Support\Facades\Gate;

trait UserCountTrait {
	
	public $unreadConversation;
	public $unreadMessages;
	public $totalConversations;
	public $totalInvitations;
	public $appliedJobs;
	public $modelCategories;

	private function calculateUserData() {

		if(\Auth::check() && auth()->user()->user_type_id == 2){

			// My Posts
			$this->myPosts = Post::where('user_id', auth()->user()->id)
				->verified()
				->unarchived()
				->reviewed()
				->with('city')
				->orderByDesc('id');
			view()->share('countMyPosts', $this->myPosts->count());
		}


		$this->unreadConversation = $this->unreadMessages = $this->totalConversations = $this->totalInvitations = $this->appliedJobs= 0;

		if(\Auth::check() && auth()->user()->user_type_id == 3){
			$this->appliedJobs = auth()->user()->appliedJobs->count();
		}

		if( Auth::check() ){
			$this->unreadConversation = count(Auth()->User()->totalunreadConversation);
			$this->unreadMessages = (count(Auth()->User()->totalUnreadMsg) + count(Auth()->User()->totalDirectUnreadMsg));
			// $totalConversations = Auth()->User()->totalConversation;
			$this->totalConversations = count(Auth()->User()->totalunreadConversation);

			if(auth()->user()->user_type_id == 2){
				$this->totalInvitations = Message::select('messages.*','posts.title','posts.description','users.user_type_id')
								->join('users', 'users.id', '=', 'messages.from_user_id')
								->join('users as u', 'u.id', '=', 'messages.to_user_id')
		 						->join('posts', 'posts.id', '=', 'messages.post_id')
								->where('from_user_id', Auth::user()->id)
								->where('parent_id', '0')
								->where('invitation_status', '0')
								->where('message_type', 'Invitation')
								->where('posts.archived', 0)
								->whereNull('users.deleted_at')
								->whereNull('u.deleted_at')
								->count();
			}else{
				$this->totalInvitations = Message::select('messages.*','posts.title','posts.description','users.user_type_id')			
								->join('users', 'users.id', '=', 'messages.to_user_id')
								->join('users as u', 'u.id', '=', 'messages.from_user_id')
		 						->join('posts', 'posts.id', '=', 'messages.post_id')
								->where('to_user_id', Auth::user()->id)
								->where('parent_id', '0')
								->where('invitation_status', '0')
								->where('message_type', 'Invitation')
								->where('posts.archived', 0)
								->whereNull('users.deleted_at')
								->whereNull('u.deleted_at')
								->count();
			}
		}
		// count all conversation

		if( \Auth::check() ){
			if(auth()->user()->user_type_id ==  config('constant.model_type_id') && Gate::allows('premium_country_free_user', auth()->user())){
				$this->unreadConversation = $this->totalConversations = $this->totalInvitations = 0;
			}
		}


		view()->share('unreadConversation', $this->unreadConversation);
		view()->share('unreadMessages', $this->unreadMessages);
		view()->share('totalConversations', $this->totalConversations);
		view()->share('totalInvitations', $this->totalInvitations);
		view()->share('appliedJobs', $this->appliedJobs);
	}
}
