<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symbols extends Model
{
    use HasFactory;

    protected $fillable = [
        'himn',
        'himn_url',
    ];

    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }
}
