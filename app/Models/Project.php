<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public const STATUSES = [
        'Pending',
        'Ongoing',
        'Completed',
    ];

    protected static function booted()
    {
        static::creating(function ($project) {
            if (auth()->check()) {
                $project->organization_id = organization()->id;
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
