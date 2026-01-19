<?php

namespace App\Jobs;

use App\Mail\NotifyMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $mail;
    protected $subject;
    protected $data;
    protected $body;
    protected $organization;
    public function __construct($mail,$subject,$data,$body,$organization)
    {
        $this->mail = $mail;
        $this->subject = $subject;
        $this->data = $data;
        $this->body = $body;
        $this->organization = $organization;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        applyMailSettings();

        Log::error('Mail ' . $this->mail);
        $data=[
            'employee_name'=> $this?->data['name'] ?? null,
            'email'=> $this?->data['email'] ?? null,
            'password'=> $this?->data['password'] ?? null,
            'joining_date'=> $this?->data['joining_date'] ?? null,
            'client_name'=> $this?->data['name'] ?? null,
            'invoice_number'=> $this?->data['invoice_number'] ?? null,
            'invoice_date'=> $this?->data['invoice_date'] ?? null,
            'due_date' => $this?->data['due_date'] ?? null,
            'amount'=> $this?->data['amount'] ?? null,
        ];

        Mail::to($this->mail)->send(new NotifyMail($this->subject, $this->body, $data,$this->organization));
    }
}
