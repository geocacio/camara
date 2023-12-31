<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'office',
        'description',
        'slug',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
