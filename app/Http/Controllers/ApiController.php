<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FrontController;
use App\Models\Invitation;
use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ApiController extends FrontController {
	public function invitation(Request $id) {
		dd($id);

		$action = htmlspecialchars($request->act);

		if ($action == '1' && Invitation::where('token', $token)->where('status', '0')->count()) {
			$putdata = array(
				'status' => '2',
			);
			$tableupdate = Invitation::where('token', $token)->update($putdata);
			$getdata = Invitation::where('token', $token)->first();
			$partnerdata = User::where('id', $getdata->partner_id)->select('id', 'name', 'email', 'phone')->first();
			$modeldata = User::where('id', $getdata->model_id)->select('id', 'name', 'email', 'phone')->first();
			$postdata = Post::where('id', $getdata->job_id)->select('title', 'id')->first();

			$message = $modeldata->name . ' ' . trans('mail.accepted_your_Job') . ' <b>' . $postdata->title . '<b>' . '<br>' . trans('mail.You_can_start_Conversation');

			$newMessage = [
				'post_id' => $postdata->id,
				'parent_id' => '0',
				'from_user_id' => $modeldata->id,
				'from_name' => ($modeldata->profile->first_name)? $modeldata->profile->first_name : $modeldata->name,
				'from_email' => $modeldata->email,
				'from_phone' => $modeldata->phone,
				'to_user_id' => $partnerdata->id,
				'to_name' => ($partnerdata->profile->first_name)? $partnerdata->profile->first_name: $partnerdata->name,
				'to_email' => $partnerdata->email,
				'to_phone' => $partnerdata->phone,
				'subject' => trans('mail.invitation_accepted'),
				'message' => $message,
			];

			$message = new Message($newMessage);
			$message->save();

		} elseif ($action == '2' && Invitation::where('token', $token)->where('status', '0')->count()) {
			$putdata = array(
				'status' => '3',
			);
			$tableupdate = Invitation::where('token', $token)->update($putdata);
		}
		Session::flash('message', 'Thanks for your response');
		return \Redirect('/');
	}

}
