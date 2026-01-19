<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Console\Command;

class SendUpcommingDuesMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-upcomming-dues-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $invoices = Invoice::with('client', 'services.service')->where('due_date', '>=', date('Y-m-d'))->latest()->get();
        foreach ($invoices as $invoice) {
            $client = Client::find($invoice->client_id);

            if ($client->email) {
                $data = [
                    'invoice_number' => $invoice->estimated_invoice,
                    'invoice_date' => $invoice->created_at->format('Y-m-d'),
                    'due_date' => $invoice->due_date,
                    'amount' => $invoice->payable_amount,
                    'name' => $client->name
                ];
                notifyMail($client->email, 'upcoming_due_mail', $data);
            }
        }
    }
}
