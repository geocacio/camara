<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function links()
    {
        return $this->belongsToMany(Link::class, 'menu_links');
    }

    public function styles()
    {
        return $this->morphMany(Style::class, 'styleable');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
