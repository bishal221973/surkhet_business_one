<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $subjects;
    protected $body;
    protected $data;

    protected $organization;
    public function __construct($subjects,$body,$data,$organization)
    {
        $this->subjects = $subjects;
        $this->body = $body;
        $this->data = $data;
        $this->organization = $organization;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->subjects;

        // Prepare the placeholders and their values
        $placeholders = [
            '{{company_name}}' => $this->organization->name,
            '{{invoice_number}}' => $this->data?->invoice_number ?? null, // make sure $this->invoice exists
            // add more if needed
        ];

        // Replace all placeholders in the subject
        $subject = str_replace(array_keys($placeholders), array_values($placeholders), $subject);

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.demoFormat',
            with: [
                'mailFormat' => $this?->body ?? null,
                'data' => [
                    'employee_name' => $this->data['employee_name'] ?? null,
                    'client_name' => $this->data['client_name'] ?? null,
                    'invoice_number' => 'INV-123',
                    'invoice_date' => today()->format('Y-m-d'),
                    'due_date' => today()->format('Y-m-d'),
                    'payment_date' => today()->format('Y-m-d'),
                    'amount' => 1000,
                    'company_name' => $this->organization->name,
                    'joining_date' => $this->data['joining_date'] ?? null,
                    'email' => $this->data['email'] ?? null,
                    'password' => $this->data['password'] ?? null,
                    'company_email' => $this->organization?->email ?? null,
                    'company_address' => $this->organization?->address ?? null
                ]
            ]
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
