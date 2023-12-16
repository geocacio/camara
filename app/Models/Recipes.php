<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipes extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_data',
        'exercise',
        'classification',
        'origin_id',
        'organ',
        'recipe_type',
        'slip_number',
        'object',
        'history_information',
        'value',
        'text_button',
        'url',
    ];
}
