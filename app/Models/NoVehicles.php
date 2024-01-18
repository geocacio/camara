<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoVehicles extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'description',
    ];

        
    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }
}
