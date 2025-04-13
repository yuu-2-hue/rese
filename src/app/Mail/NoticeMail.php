<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $sender;
    public $mainText;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $sender, $mainText)
    {
        $this->subject = $subject;
        $this->sender = $sender;
        $this->mainText = $mainText;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->view('email.notice')
            ->from($this->sender)
            ->with('mainText', $this->mainText);
    }
}
