<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function upcoming()
    {
        $invoices=Invoice::with('client', 'services.service')->where('due_date', '>=', date('Y-m-d'))->latest()->get();
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
}
