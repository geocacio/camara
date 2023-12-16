<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamberFinancial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'description',
        'date',
        'slug',
    ];

    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
