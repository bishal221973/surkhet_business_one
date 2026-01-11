<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function rules(){
        return [
            'name' => 'required',
            'balance' => 'required',
            'description' => 'nullable',
        ];
    }

    protected static function boot(){
        Parent::boot();
        static::creating(function($bank){
            $bank->organization_id = organization()->id;
        });
    }
}
