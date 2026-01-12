<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceService extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot(){
        parent::boot();
        static::creating(function($invoiceservice){
            $invoiceservice->organization_id = organization()->id;
        });
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
