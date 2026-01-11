<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMode extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function rules(){
        return[
            'name'=>'required',
            'description'=>'nullable',
        ];
    }

    protected static function boot(){
        parent::boot();

        static::creating(function($paymentmode){
            $paymentmode->organization_id = organization()->id;
        });
    }
}
