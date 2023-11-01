<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OmbudsmanPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_title',
        'title',
        'icon',
        'description',
        'route',
        'visibility',
        'slug',
    ];

    public function publications()
    {
        return $this->hasMany(Publication::class, 'page_id');
    }

    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function groupContents()
    {
        return $this->morphOne(TransparencyGroupContent::class, 'pageable');
    }
}
