<?php

namespace App\Plugins\offlinepayment\app\Mail;

use App\Models\Package;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;

class PaymentSent extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $post;
    public $package;
	public $paymentMethod;

    /**
     * PaymentSent constructor.
     * @param Payment $payment
     * @param Post $post
     */
    public function __construct(Payment $payment, Post $post)
    {
        $this->payment = $payment;
        $this->post = $post;
		$this->package = Package::transById($payment->package_id);
		$this->paymentMethod = PaymentMethod::find($payment->payment_method_id);

        $this->to($post->email, $post->contact_name);
        $this->subject(trans('offlinepayment::mail.payment_sent_title'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('payment::emails.payment.sent');
    }
}
