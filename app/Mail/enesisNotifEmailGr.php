<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class enesisNotifEmailGr extends Mailable
{
    use Queueable, SerializesModels;

    public $po;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($po, $name)
    {
        $this->po = $po;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Good Receipts')->view('emails.vendors.purchaseOrderGr');
    }
}
