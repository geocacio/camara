<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginScreen extends Model
{
    use HasFactory;

    protected $fillable = [
        'background',
        'card_color',
        'button_color',
        'button_hover',
        'card_position',
        'modal',
    ];
}
