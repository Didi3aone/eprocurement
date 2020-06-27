<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class enesisApprovalAcpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $acp;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($acp, $name)
    {
        $this->acp = $acp;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('ACP - APPROVAL')->view('emails.acpApproval');
    }
}
