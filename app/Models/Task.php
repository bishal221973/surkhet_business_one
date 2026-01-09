<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public const STATUSES = [
        'Pending',
        'Ongoing',
        'Completed',
    ];

    public const PRIORITY = [
        'Low',
        'Medium',
        'High',
    ];

    protected static function booted()
    {
        static::creating(function ($task) {
            if (auth()->check()) {
                $task->organization_id = organization()->id;
            }
        });
    }

    protected $casts = [
        'assigned_to' => 'array', // JSON <-> array automatically
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    // public function assignedTo(){
    //     return $this->belongsTo(User::class);
    // }

    public function assignedUsers()
    {
        return User::whereIn('id', $this->assigned_to)->get();
    }
}
