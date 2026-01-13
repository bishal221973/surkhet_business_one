<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function upcoming()
    {
        $invoices = Invoice::with('client', 'services.service')->where('due_date', '>=', date('Y-m-d'))->latest()->get();
        return view('reports.upcoming', [
            'invoices' => $invoices,
            'invoice' => new Invoice(),
        ]);
    }

    public function overdues()
    {
        $invoices = Invoice::with('client', 'services.service')->where('due_date', '<=', date('Y-m-d'))->latest()->get();
        return view('reports.overdues', [
            'invoices' => $invoices,
            'invoice' => new Invoice(),
        ]);
    }

    public function profitLoss(Request $request)
    {
        // Date range
        // $from = $request->from ?? now()->startOfMonth()->format('Y-m-d');
        // $to = $request->to ?? now()->endOfMonth()->format('Y-m-d');


        if ($request->filled('month')) {

            $from = Carbon::createFromFormat('Y-m', $request->month)
                ->startOfMonth()
                ->format('Y-m-d');

            $to = Carbon::createFromFormat('Y-m', $request->month)
                ->endOfMonth()
                ->format('Y-m-d');

        } else {

            // Default: current month
            $from = now()->startOfMonth()->format('Y-m-d');
            $to = now()->endOfMonth()->format('Y-m-d');
        }

        // --- Opening Balance (net profit before the period) ---
        $totalIncomeBefore = DB::table('incomes')
            ->where('payment_date', '<', $from)
            ->sum('amount');

        $totalPaymentsBefore = DB::table('payments')
            ->where('payment_date', '<', $from)
            ->sum('amount');

        $totalExpensesBefore = DB::table('expenses')
            ->where('payment_date', '<', $from)
            ->sum('amount');

        $openingBalance = ($totalIncomeBefore + $totalPaymentsBefore) - $totalExpensesBefore;

        // --- Income for period ---
        $incomes = DB::table('incomes')
            ->select('payment_date', 'title as description', 'amount')
            ->whereBetween('payment_date', [$from, $to])
            ->orderBy('payment_date', 'asc')
            ->get();

        // --- Payments Received for period ---
        $payments = DB::table('payments')
            ->select('payment_date', DB::raw("CONCAT('Payment received for Invoice #', invoice_id) as description"), 'amount')
            ->whereBetween('payment_date', [$from, $to])
            ->orderBy('payment_date', 'asc')
            ->get();

        // --- Expenses for period ---
        // $expenses = DB::table('expenses')
        //     ->select('payment_date', 'title as description', 'amount')
        //     ->whereBetween('payment_date', [$from, $to])
        //     ->orderBy('payment_date', 'asc')
        //     ->get();
        $expenses = DB::table('expenses')
            ->select(
                'payment_date',
                DB::raw("
            CASE
                WHEN expenses.title IS NULL OR expenses.title = ''
                THEN 'Expense'
                ELSE CONCAT('Expense on ', expenses.title)
            END AS description
        "),
                'amount'
            )
            ->whereBetween('payment_date', [$from, $to])
            ->orderBy('payment_date', 'asc')
            ->get();


        // --- Prepare Dr and Cr arrays ---
        $dr = $expenses->toArray(); // Expenses go to Dr
        $cr = $incomes->toArray();  // Income goes to Cr
        $cr = array_merge($cr, $payments->toArray()); // Add Payments Received to Cr

        // Include Opening Balance in Cr if positive, or Dr if negative
        if ($openingBalance > 0) {
            array_unshift($cr, (object) [
                'payment_date' => $from,
                'description' => 'Opening Balance',
                'amount' => $openingBalance
            ]);
        } elseif ($openingBalance < 0) {
            array_unshift($dr, (object) [
                'payment_date' => $from,
                'description' => 'Opening Balance',
                'amount' => abs($openingBalance)
            ]);
        }

        // Totals
        $totalDr = array_sum(array_column($dr, 'amount'));
        $totalCr = array_sum(array_column($cr, 'amount'));

        return view('reports.profitLoss', compact(
            'dr',
            'cr',
            'totalDr',
            'totalCr',
            'from',
            'to'
        ));
    }


}
