<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['page_id', 'component', 'name', 'position', 'visibility', 'slug'];

    public function page()
    {
        return $this->belongsTo(Page::class);
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
