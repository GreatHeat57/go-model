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

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use App\Models\Message;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Html2text;

class DirectMessage extends Mailable
{
	use Queueable, SerializesModels;
	
	public $msg; // CAUTION: Conflict between the Model Message $message and the Laravel Mail Message objects
	
	/**
	 * Create a new message instance.
	 *
	 * @param Post $post
	 * @param Message $msg
	 */
	public function __construct(Message $msg)
	{
		$this->msg = $msg;
		$this->to($msg->to_email, $msg->to_name);
		
		$this->replyTo($msg->from_email, $msg->from_name);
		$this->subject(trans('mail.:user has send you a message', ['user'   => $msg->from_name]));
	}
	
	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{

        $msg = $this->msg;

        $html = view('emails.post.direct_message', compact('msg'))->render();
        
        $htmlview = new Html2text($html);
        $text = $htmlview->getText();
        
        return $this->view('emails.post.direct_message')->text('emails.plain_text')->with('text', $text);
        
		// return $this->view('emails.post.employer-contacted');

	}
}
