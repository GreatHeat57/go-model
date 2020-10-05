<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Html2text;

class InvitationAccepted extends Mailable
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
        $html = view('emails.invitation_accepted', compact('data'))->render();
        
        $htmlview = new Html2text($html);
        $text = $htmlview->getText();

        return $this->to($this->data['partner_email'],$this->data['partner_name'])
                    ->subject(trans('mail.invitation_accepted'))
                    ->view('emails.invitation_accepted',['data' => $this->data])
                    ->text('emails.plain_text')->with('text', $text);
    }
}
