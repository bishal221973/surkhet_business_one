<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ClientLedger extends Component
{
    /**
     * Create a new component instance.
     */
    public $client;
    public $ledger;
    public function __construct($client)
    {
        $this->client = $client;
        $this->ledger = $this->buildLedger();
    }

    private function buildLedger()
    {
        $ledger = collect();

        foreach ($this->client->invoices as $invoice) {
            // Invoice row
            $ledger->push([
                'date' => $invoice->created_at,
                'type' => 'Invoice',
                'ref' => $invoice->invoice_number,
                'debit' => (float) $invoice->total,
                'credit' => 0,
            ]);

            // Payment rows (child but shown independently)
            foreach ($invoice->payments as $payment) {
                $ledger->push([
                    'date' => $payment->created_at,
                    'type' => 'Payment',
                    'ref' => '-',
                    'debit' => 0,
                    'credit' => (float) $payment->amount,
                ]);
            }
        }

        // Sort by created_at
        $ledger = $ledger->sortBy('date')->values();

        // Running balance
        $balance = 0;
        return $ledger->map(function ($row) use (&$balance) {
            $balance += $row['debit'];
            $balance -= $row['credit'];
            $row['balance'] = $balance;
            return $row;
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client-ledger');
    }
}
