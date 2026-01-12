<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $guarded=['id'];


    protected static function boot()
    {
        parent::boot();
       static::creating(function($unit){
           $unit->organization_id = organization()->id;
       });
    }
    protected static function rules(){
        return [
            'name' => 'required',
            'description' => 'nullable',
        ];
    }
}
