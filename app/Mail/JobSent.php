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
use App\Helpers\Html2text;

class JobSent extends Mailable {
	use Queueable, SerializesModels;

	public $msg;

	/**
	 * Create a new message instance.
	 *
	 * @param $request
	 * @param $recipient
	 */
	public function __construct($request, $recipient) {
		$this->msg = $request;

		$this->from($request->email, $request->first_name);
		$this->to($recipient->email, $recipient->name);
		$this->replyTo($request->email, $request->first_name); // . ' ' . $request->last_name
		$this->subject($request->subject);
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {

		$msg = $this->msg;

        $html = view('emails.guest-job', compact('msg'))->render();
        
        $htmlview = new Html2text($html);
        $text = $htmlview->getText();
        
        return $this->view('emails.guest-job')->text('emails.plain_text')->with('text', $text);
		// return $this->view('emails.guest-job');
	}
}
