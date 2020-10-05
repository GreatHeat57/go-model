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

class UserNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * UserNotification constructor.
     * @param $user
     * @param $adminUser
     */
    public function __construct($user, $adminUser)
    {
        $this->user = $user;
        
        $this->to($adminUser->email, $adminUser->name);
        $this->subject(trans('mail.user_notification_title'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;

        $html = view('emails.user.notification', compact('user'))->render();
        
        $htmlview = new Html2text($html);
        $text = $htmlview->getText();
        
        return $this->view('emails.user.notification')->text('emails.plain_text')->with('text', $text);
        // return $this->view('emails.user.notification');
    }
}
