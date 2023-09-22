<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendQuotationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {
            return $this->subject($this->details["subject"])
                    ->view('email.'.$this->details["type"]);
            // switch($this->details["type"]){
            //     case 'quotation':
            //         return $this->subject($this->details["subject"])
            //         ->view('email.quotation');
            //     break;
            //     case "paylink":
            //         return $this->subject($this->details["subject"])
            //         ->view('email.paylink');
            //     break;
            //     case "download":
            //         return $this->subject($this->details["subject"])
            //         ->view('email.download');
            //     break;
            // }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
