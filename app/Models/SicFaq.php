<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SicFaq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
