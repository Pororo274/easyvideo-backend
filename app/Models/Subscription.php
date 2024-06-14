<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'cost', 'work_until', 'accepted_at'
    ];

    protected $casts = [
        'work_until' => 'datetime',
        'accepted_at' => 'datetime'
    ];
}
