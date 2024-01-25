<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'description',
        'periodo',
    ];

    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }
}
