<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUsPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'telefone',
        'opening_hours',
        'email',
        'status',
    ];
}
