<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageServiceLetter extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'slug'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
