<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

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
}
