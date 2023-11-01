<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['icon', 'title', 'text', 'type', 'url', 'slug'];

    public function getRouteKeyName(){
        return 'slug';
    }
}

