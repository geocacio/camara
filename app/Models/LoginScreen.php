<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginScreen extends Model
{
    use HasFactory;

    protected $fillable = [
        'background',
        'logo',
        'card_color',
        'button_color',
        'button_hover',
        'card_position',
        'modal',
        'style_background',
        'style_modal',
        'show_logo',
    ];
}
