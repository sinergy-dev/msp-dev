<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApproveDeliveryOrder extends Mailable
{
    use Queueable, SerializesModels;
    public $customSubject,$detail_barang,$details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customSubject,$detail_barang,$details)
    {
        $this->customSubject = $customSubject;
        $this->detail_barang = $detail_barang;
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->customSubject.' - '.$this->details->no_do)
                    ->view('mail.MailApproveDO');
    }
}
