<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransparencyGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'transparency_id',
        'title',
        'description',
        // 'category_id',
        // 'law_id',
        'slug',
    ];

    public function tranparencyPortal(){
        return $this->belongsTo(TransparencyPortal::class);
    }

    public function contents()
    {
        return $this->hasMany(TransparencyGroupContent::class);
    }
    public function categories()
    {
        return $this->morphMany(CategoryContent::class, 'categoryable');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
