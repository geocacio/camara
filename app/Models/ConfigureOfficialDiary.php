<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigureOfficialDiary extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'text_one',
        'text_two',
        'text_three',
        'footer_title',
        'footer_text',
        'presentation',
        'normatives',
    ];

    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }
}
