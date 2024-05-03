<?php

namespace App\Mail;

use App\Models\email_template;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class mahnung extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $id;
    public $lead;

    public $body;

    public $mail;

    public function __construct($id, $lead)
    {
        $this->id = $id;
        $this->lead = $lead;
        $mail = email_template::where("id", "135")->first();
        $this->mail = $mail;
        $this->body = $mail->body;
    }
    
    

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->mail->subject,
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
            view: 'mails/custom_mail',
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
            Attachment::fromPath('rechnungspdfs/mahnung-'. $this->id . ".pdf"),
            Attachment::fromPath('rechnungspdfs/rechnung-'. $this->id . ".pdf"),
        ];
    }
}
