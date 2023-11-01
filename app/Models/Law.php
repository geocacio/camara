<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Law extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'exercicy_id',
        'competency_id',
        'date',
        'description',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function categories()
    {
        return $this->morphMany(CategoryContent::class, 'categoryable');
    }

    public function exercicy()
    {
        return $this->belongsTo(Category::class, 'exercicy_id');
    }

    public function competency()
    {
        return $this->belongsTo(Category::class, 'competency_id');
    }

    public function types()
    {
        return $this->morphToMany(Type::class, 'typeable', 'type_contents');
    }
    
    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }
}
