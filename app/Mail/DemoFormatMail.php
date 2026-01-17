<?php

namespace App\Mail;

use App\Models\MailFormat;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\OrganizationSetting;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class DemoFormatMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $mailFormat;
    protected $organization;

    public function __construct(MailFormat $mailFormat,$organization)
    {
        $this->mailFormat = $mailFormat;
        $this->organization = $organization;

        // Apply SMTP settings inside queued job

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        $subject = $this->mailFormat->subject;

        // Replace placeholders dynamically
        $subject = str_replace(
            ['{{company_name}}'],
            [$this->organization->name], // actual company name
            $subject
        );
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
                'mailFormat' => $this->mailFormat,
                'data' => [
                    'employee_name' => 'John Doe',
                    'client_name' => 'John Doe',
                    'company_name' => $this->organization->name,
                    'joining_date' => today()->format('Y-m-d'),
                    'email' => 'john.doe@example.com',
                    'password' => 'secret123',
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
