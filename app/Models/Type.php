<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'parent_id', 'slug'];

    public function typeContents()
    {
        return $this->hasMany(TypeContent::class);
    }

    public function children()
    {
        return $this->hasMany(Type::class, 'parent_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
