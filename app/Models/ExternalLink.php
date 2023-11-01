<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'description',
        'icon',
        'visibility',
        'slug',
    ];

    public function groupContents()
    {
        return $this->morphOne(TransparencyGroupContent::class, 'pageable');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
