<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentStyle extends Model
{
    use HasFactory;

    protected $fillable = ['model'];

    public function styles()
    {
        return $this->morphMany(Style::class, 'styleable');
    }
}
