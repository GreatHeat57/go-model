<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Html2text;

class MassgaeEmailSent extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $data = $this->data;
// echo '<pre>';print_r($data);die();
        $html = view('emails.massege_email', compact('data'))->render();
        $htmlview = new Html2text($html);
        $from_name=$data['from_name'];
        $text = $htmlview->getText();
        $subject=trans('mail.contact_form_title', [ 'appName' => $from_name]);
        return $this->to($this->data['to_email'],$this->data['to_name'])
                    ->subject($subject)
                    ->view('emails.massege_email',['data' => $this->data])
                    ->text('emails.plain_text')->with('text', $text);
    }
}
