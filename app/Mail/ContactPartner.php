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

class ContactPartner extends Mailable
{
    use Queueable, SerializesModels;

    public $partner, $model, $msg;

    /**
     * ContactPartner constructor.
     * @param $post
     * @param $adminUser
     */
    public function __construct($partner, $model, $message)
    {
        $this->partner = $partner;
        $this->model = $model;
        $this->msg = $message;

        $this->to($partner->email, isset($partner->profile->first_name)?$partner->profile->first_name : '');
        $modelname = isset($message['name'])? $message['name'] : t('Model');
        $this->subject(trans('mail.Hello, :model has send you a message', [ 'model' => $modelname]));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $partner = $this->partner;
        $model = $this->model;
        $msg = $this->msg;

        $html = view('emails.post.partner-contact', compact('partner', 'model', 'msg'))->render();
        
        $htmlview = new Html2text($html);
        $text = $htmlview->getText();
        
        return $this->view('emails.post.partner-contact')->text('emails.plain_text')->with('text', $text);
        // return $this->view('emails.post.partner-contact');
    }
}
