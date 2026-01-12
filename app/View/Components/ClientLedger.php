<?php

namespace App\View\Components;

use Closure;
use App\Models\Invoice;
use App\Models\Fiscalyear;
use App\Models\Payment;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ClientLedger extends Component
{
    /**
     * Create a new component instance.
     */
    public $client;
    public $ledger;
    public $closingBalance;
    public function __construct($client)
    {
        $this->client = $client;
        $this->ledger = $this->buildLedger();
    }

    private function getPreviousYearClosingBalance($currentFiscalYearId)
    {
        $prevYear = Fiscalyear::where('id', '<', $currentFiscalYearId)
            ->orderByDesc('id')
            ->first();

        if (!$prevYear) {
            return 0;
        }

        $invoiceTotal = Invoice::where('client_id', $this->client->id)
            ->where('fiscalyear_id', $prevYear->id)
            ->sum('total');

        $paymentTotal = Payment::whereHas('invoice', function ($q) use ($prevYear) {
            $q->where('client_id', $this->client->id)
                ->where('fiscalyear_id', $prevYear->id);
        })
            ->sum('amount');

        return (float) ($invoiceTotal - $paymentTotal);
    }


    private function buildLedger()
    {
        $ledger = collect();

        // 1️⃣ Push opening balance row
        $openingBalance = $this->getPreviousYearClosingBalance(fiscalyear()->id); // implement this
        $ledger->push([
            'date' => null,
            'type' => 'Opening Balance',
            'ref' => 'Prev. Year Closing',
            'debit' => 0,
            'credit' => 0,
            'balance' => $openingBalance,
        ]);

        // 2️⃣ Push invoices and payments
        foreach ($this->client->invoices as $invoice) {
            $ledger->push([
                'date' => $invoice->created_at,
                'type' => 'Invoice',
                'ref' => $invoice->invoice_number,
                'debit' => (float) $invoice->total,
                'credit' => 0,
            ]);

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

        // 3️⃣ Sort, keep opening balance first
        $ledger = $ledger->sortBy(fn($row) => $row['date'] ?? now()->subYears(100))->values();

        // 4️⃣ Running balance
        $balance = $openingBalance;
        return $ledger->map(function ($row, $index) use (&$balance) {
            if ($index !== 0) { // skip opening balance row
                $balance += $row['debit'];
                $balance -= $row['credit'];
            }
            $row['balance'] = $balance;
            return $row;
        });

        $this->closingBalance = $ledger->last()['balance'] ?? $openingBalance;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client-ledger');
    }
}
