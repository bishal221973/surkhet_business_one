<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function($service){
            $service->organization_id = organization()->id;
        });
    }

    protected static function rules(){
        return [
            'name' => 'required',
            'rate' => 'required',
            'unit_id' => 'required',
            'type' => 'nullable',
            'description' => 'nullable',
        ];
    }

    public function unit(){
        return $this->belongsTo(Unit::class);
    }
}
