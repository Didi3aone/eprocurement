<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Vendor\Vendor;

class VendorRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $vendor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verify registration')
            ->view('emails.vendor.register')
            ->with([
                'vendor' => $this->vendor,
            ]);
    }
}
