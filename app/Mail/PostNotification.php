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

class PostNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $post;

    /**
     * PostNotification constructor.
     * @param $post
     * @param $adminUser
     */
    public function __construct($post, $adminUser)
    {
        $this->post = $post;

        $this->to($adminUser->email, $adminUser->name);
        $this->subject(trans('mail.post_notification_title'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $post = $this->post;
        $html = view('emails.post.notification', compact('post'))->render();
        $htmlview = new Html2text($html);
        $text = $htmlview->getText();
        return $this->view('emails.post.notification')->text('emails.plain_text')->with('text', $text);
        // return $this->view('emails.post.notification');
    }
}
