<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration',
        'url',
        'video_source',
        'views',
        'slug',
    ];
    
    public function categories()
    {
        return $this->morphMany(CategoryContent::class, 'categoryable');
    }
    
    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function getRouteKeyName(){
        return 'slug';
    }
}
