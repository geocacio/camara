<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    use HasFactory;
    protected $fillable = [
        'styleable_type',
        'styleable_id',
        'name',
        'type_style',
        'classes',
        'background_color',
        'background_color_night',
        'title_color',
        'title_color_night',
        'title_size',
        'subtitle_color',
        'subtitle_color_night',
        'subtitle_size',
        'description_color',
        'description_color_night',
        'description_size',
        'button_text_color',
        'button_text_color_night',
        'button_text_size',
        'button_background_color',
        'button_background_color_night',
    ];

    public function styleable()
    {
        return $this->morphTo();
    }
}
