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

class PostDeleted extends Mailable
{
    use Queueable, SerializesModels;

    public $post;

    /**
     * Create a new message instance.
     *
     * @param $post
     */
    public function __construct($post)
    {
        $this->post = $post;

        $this->to($post->email, $post->contact_name);
        $this->subject(trans('mail.post_deleted_title', ['title' => $post->title]));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $post = $this->post;
        $html = view('emails.post.deleted', compact('post'))->render();
        $htmlview = new Html2text($html);
        $text = $htmlview->getText();
        return $this->view('emails.post.deleted')->text('emails.plain_text')->with('text', $text);
        // return $this->view('emails.post.deleted');
    }
}
