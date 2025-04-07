<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $sender;
    public $recipient;
    public $mainText;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $sender, $recipient, $mainText)
    {
        $this->subject = $subject;
        $this->sender = $sender;
        $this->recipient = $recipient;
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
            ->to($this->recipient)
            ->from($this->sender)
            ->with('mainText', $this->mainText);
    }
}
