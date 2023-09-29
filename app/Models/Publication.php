<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'secretary_id',
        'title',
        'number',
        'description',
        'group_id',
        'type_id',
        'competency_id',
        'exercicy_id',
        'visibility',
        'views',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function secretary()
    {
        return $this->belongsTo(Secretary::class);
    }

    public function categories()
    {
        return $this->morphMany(CategoryContent::class, 'categoryable');
    }
}
