<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($department) {
            $department->user_id = auth()?->id() ?? 1;
            $department->organization_id = auth()?->user()?->organization_id ?? 1;
            $department->date=now()->format('Y-m-d');
            $department->date_bs = ad_to_bs(now()->format('Y-m-d'));
            $department->time=now()->format('h:i:s');
        });
    }
}
