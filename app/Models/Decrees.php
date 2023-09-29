<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Decrees extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'date',
        'description',
        'group_id',
        'exercicy_id',
        'views',
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

    public function group()
    {
        return $this->belongsTo(Category::class, 'group_id');
    }

    public function types()
    {
        return $this->morphToMany(Type::class, 'typeable', 'type_contents');
    }
    
    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function decreePage()
    {
        return $this->belongsTo(DecreePage::class);
    }
}
