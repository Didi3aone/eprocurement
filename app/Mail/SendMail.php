<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable;
    use SerializesModels;
    private $po;

    /**
     * Create a new message instance.
     *
     * @param mixed $po
     *
     * @return void
     */
    public function __construct($po)
    {
        $this->po = $po;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = $this->po->vendors['name'].'_'.$this->po->PO_NUMBER;

        return $this->view('print')
        ->with([
            'po' => $this->po,
            'print' => true,
        ])->attachFromStorage("public/{$this->po->id}_print.pdf", "{$name}.pdf", [
            'mime' => 'application/pdf',
        ]);
    }
}