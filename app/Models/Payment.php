<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot(){
        Parent::boot();
        static::creating(function($payment){
            $payment->organization_id = organization()->id;
            $payment->receiver_id = auth()->id();
            $payment->fiscalyear_id = fiscalyear()->id;
        });

        static::created(function ($payment) {
            if ($payment->bank_id) {
                $payment->bank->increment('balance', $payment->amount);
            }
            if ($payment->invoice_id) {
                $payment->invoice()->decrement('payable_amount', $payment->amount);
            }
        });

    }

    protected static function rules(){
        return [
            'invoice_id' => 'required',
            'client_id' => 'required',
            'payment_mode_id' => 'required',
            'bank_id' => 'required',
            'payment_date' => 'required',
            'amount' => 'required',
            'description' => 'nullable',
        ];
    }

    public function bank(){
        return $this->belongsTo(Bank::class);
    }

    public function paymentMode(){
        return $this->belongsTo(PaymentMode::class);
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function receiver(){
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
