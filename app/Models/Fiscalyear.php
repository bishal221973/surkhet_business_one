<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fiscalyear extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function rules()
    {
        return [
            'name' => 'required|max:255',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'is_active' => 'required',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($fiscalyear) {
            if (auth()->check()) {
                $fiscalyear->created_by = auth()->id();
                $fiscalyear->organization_id = organization()->id;
            }
        });
    }
}
