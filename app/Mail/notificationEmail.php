<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class notificationEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $person;
    public $body;
    /**
     * Create a new message instance.
     */
    public function __construct($person, $body)
    {
        $this->person = $person;
        $this->body = $body;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('admin.m365@bakrieoleo.com', 'BRC Mail service'),
            subject: $this->body['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->body['subject'] == "License Equipment is Running") {
            $view = 'livewire.mail.license-running';
        } elseif ($this->body['subject'] == "Need Re License Equipment") {
            $view = 'livewire.mail.re-license';
        } else {
            $view = 'livewire.mail.index';
        }

        return new Content(
            view: $view,
            with: [
                'fullname' => $this->person->fullname,
                'doc_no' => $this->body['doc_no'],
                'subject' => $this->body['subject'],
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
