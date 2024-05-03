<?php

namespace App\Mail;

use App\Models\active_orders_car_data;
use App\Models\emails_history;
use App\Models\emailUUID;
use App\Models\file;
use App\Models\new_leads_car_data;
use App\Models\status_histori;
use App\Models\statuse;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class mail_template extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;

    public $mail;

    public $car;

    public $anhang;

    public $pixelUUID;

    public $status;
    public $subject;
    public $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($lead, $subject, $body, $anhang = null)
    {
        $this->lead = $lead;
        if (active_orders_car_data::where('process_id', $lead->process_id)->first() == null) {
            $this->car = new_leads_car_data::where('process_id', $lead->process_id)->first();
        } else {
            $this->car = active_orders_car_data::where('process_id', $lead->process_id)->first();
        }

        $this->subject = $subject;

        $this->body = $body;

        $this->pixelUUID = uniqid();

        $uuid = new emailUUID();
        $uuid->process_id = $lead->process_id;
        $uuid->uuid = $this->pixelUUID;
        $uuid->count = 0;
        $uuid->save();

        $this->anhang = $anhang;


        $status  = status_histori::where("process_id", $lead->process_id)->latest()->first();
        $this->status = statuse::where("id", $status->last_status)->first();
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
            view: 'mails/email_vorlage',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        if ($this->anhang != null) {
            return [
                Attachment::fromPath('files/aufträge/'.$this->lead->process_id.'/'.$this->anhang),
            ];
        }

         
    }
}
