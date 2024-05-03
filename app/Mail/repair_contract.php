<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class repair_contract extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;

    public $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($lead, $email, $id)
    {
        $this->lead = $lead;

        $this->id = $id;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Repair Contract',
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
            view: 'mails/repair_contract',
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
            Attachment::fromPath('files/aufträge/'.$this->id.'/'.$this->id.'-contract.pdf'),
        ];
    }
}
