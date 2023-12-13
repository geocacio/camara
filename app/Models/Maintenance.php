<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'text', 'more_info', 'start_date', 'end_date', 'status'];

    protected $casts = [
        'status' => 'boolean',
    ];
}
