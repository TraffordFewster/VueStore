<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Invoice;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
    public $invoice;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $Invoice)
    {
        $this->invoice = $Invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $id = $this->invoice->id;
        return $this->subject("Invoice #$id")->view('email.invoice');
    }
}
