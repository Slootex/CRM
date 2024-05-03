<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class rechnung extends Mailable
{
    use Queueable, SerializesModels;

    public $text;
    public $subject;

    public $rechnungsnummer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($text, $subject, $rechnungsnummer)
    {
        $this->text = $text;
        $this->rechnungsnummer = $rechnungsnummer;
        $this->subject = $subject;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->subject,
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
        return [
            Attachment::fromStorage("/rechnungspdfs/" . "rechnung-". $this->rechnungsnummer . ".pdf"),
        ];
    }
}
