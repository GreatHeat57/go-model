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

namespace App\Listeners;

use App\Events\UserWasVisited;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use App\Models\UserView;

class UpdateTheUserCounter
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Handle the event.
     *
     * @param  PostWasVisited $event
     * @return bool|void
     */
    public function handle(UserWasVisited $event)
    {
        // Don't count the self-visits
        if (Auth::check()) {
            if (Auth::user()->id == $event->user->id) {
                return false;
            }
        }

		// if (!session()->has('postIsVisited')) {
		// 	return $this->updateCounter($event->post);
		// } else {
		// 	if (session()->get('postIsVisited') != $event->post->id) {
		// 		return $this->updateCounter($event->post);
		// 	} else {
		// 		return false;
		// 	}
		// }
        $ip_address = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
          $ip_address=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
          $ip_address=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else if(!empty($_SERVER['HTTP_X_FORWARDED']))
        {
            $ip_address = $_SERVER['HTTP_X_FORWARDED'];
        }
        else if(!empty($_SERVER['HTTP_FORWARDED_FOR']))
        {
            $ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
        }
        else if(!empty($_SERVER['HTTP_FORWARDED']))
        {
            $ip_address = $_SERVER['HTTP_FORWARDED'];
        }
        else if(!empty($_SERVER['REMOTE_ADDR']))
        {
            $ip_address=$_SERVER['REMOTE_ADDR'];
        }
        else
        {
            $ip_address = 'UNKNOWN';
        }
        $userView = UserView::where('ip_address', $ip_address)->where('user_id',$event->user->id)->first();
        if ($userView === null) {
           return $this->updateUserView($event->user->id, $ip_address);
        }
        
    }

	/**
	 * @param $post
	 */
    public function updateUserView($user_id,$ip_address)
    {
        $userView = new UserView([
            'user_id' => $user_id,
            'ip_address' => $ip_address,
            'date' => date('Y-m-d H:i:s')
        ]);
        $userView->save();
    }
}
