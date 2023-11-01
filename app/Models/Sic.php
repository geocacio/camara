<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sic extends Model
{
    use HasFactory;

    protected $fillable = [
        'manager',
        'phone',
        'email',
        'cep',
        'street',
        'number',
        'complement',
        'neighborhood',
        'opening_hours',
    ];
}
