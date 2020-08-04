<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class poApprovalAssproc extends Mailable
{
    use Queueable, SerializesModels;

    public $quotation;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($quotation, $name)
    {
        $this->quotation = $quotation;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Purchase Order')->view('emails.poApprovalAssproc');
    }
}
