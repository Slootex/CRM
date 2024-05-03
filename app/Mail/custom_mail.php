<?php

namespace App\Mail;

use App\Models\status_histori;
use App\Models\statuse;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class custom_mail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $body;

    public $subject;

    public $lead;

    public $car;

    public $status;

    public function __construct($subject, $body, $lead, $car)
    {
        $this->body = $body;
        $this->subject = $subject;
        $this->lead = $lead;
        $this->car = $car;

        $this->status  = status_histori::where("process_id", $lead->process_id)->first();
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
        return [];
    }
}
