<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class enesisPurchaseRequestAdminDpj extends Mailable
{
    use Queueable, SerializesModels;

    public $pr;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pr, $name)
    {
        $this->pr = $pr;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Purchase Request')->view('email.purchaseRequestAdminDpj');
    }
}
