<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class billingIncompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $billing;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($billing, $name)
    {
        $this->billing = $billing;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('BILLING ID '.$this->billing->billing_no." INCOMPLETED")->view('emails.billing.billingIncompleted');
    }
}
