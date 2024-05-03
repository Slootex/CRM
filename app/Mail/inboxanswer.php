<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class inboxanswer extends Mailable
{
    use Queueable, SerializesModels;

    public $text;
    public $awd;
    public $subject;

    public $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($text, $subject, $awd, $file)
    {
        $this->text = $text;
        $this->awd = $awd;
        $this->subject = $subject;
        $this->file = $file;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Re: ' . $this->subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mails.test',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        if($this->file != null) {
            return [
                Attachment::fromStorage("emailinbox/". $this->file->getClientOriginalName()),
            ];
        } else {
            return[];
        }
    }
}
