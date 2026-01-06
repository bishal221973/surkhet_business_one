<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::creating(function ($client) {
            // Assuming there's a way to get the current organization ID
            $client->organization_id = auth()->user()->organization_id;
        });
    }

    protected static function rules()
    {
        return [
            'name' => 'required|max:255',
            'type' => 'required|in:Customer,Company',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:20',
            'address' => 'nullable|max:500',
            'vat_number' => 'nullable|max:100',
            'remarks' => 'nullable',
        ];
    }
}
