<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;


    protected $guarded = ['id'];

    protected static function rules(){
        return[
            'client_id'=>'required',
            'invoice_number'=>'required',
            'sub_total'=>'required',
            'discount'=>'required',
            'net_amount' => 'required',
            'vat_amount'=>'required',
            'total' => 'required',
            'due_date' => 'required',
            'remarks' => 'nullable',
            // 'estimated_invoice' => 'required'
        ];
    }

    protected static function boot(){
        parent::boot();
        static::creating(function($invoice){
            $estimated_invoice = 1;
            $firstInvoice = Invoice::latest()->first();

            if ($firstInvoice) {
                $estimated_invoice = $firstInvoice->estimated_invoice + 1;
            }
            $invoice->organization_id = organization()->id;
            $invoice->invoice_date = now()->format('Y-m-d');
            $invoice->status="Unpaid";
            $invoice->payable_amount = $invoice->total;
            $invoice->fiscalyear_id = fiscalyear()->id;
            $invoice->estimated_invoice = $estimated_invoice;
        });
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function payments(){
        return $this->hasMany(Payment::class);
    }
}
