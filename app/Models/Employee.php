<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function rules(){
        return [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'password' => 'required',
            'profile' => 'nullable',
            'salary' => 'required',
            'joining_date' => 'required',
            'role' => 'required',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            $employee->organization_id = organization()->id;
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
