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
        ];
    }

    protected static function boot(){
        parent::boot();
        static::creating(function($invoice){
            $invoice->organization_id = auth()->user()->organization_id;
            $invoice->invoice_date = now()->format('Y-m-d');
            $invoice->status="Unpaid";
        });
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
