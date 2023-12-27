<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordinance extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_id',
        'page_id',
        'number',
        'date',
        'agent',
        'detail',
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

    public function types()
    {
        return $this->morphToMany(Type::class, 'typeable', 'type_contents');
    }

    public function secretaries()
    {
        return $this->morphToMany(Secretary::class, 'secretaryable', 'secretary_contents');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
