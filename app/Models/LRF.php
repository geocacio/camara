<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LRF extends Model
{
    use HasFactory;

    protected $table = 'lrfs';

    protected $fillable = [
        'date',
        'details',
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

    public function getRouteKeyName(){
        return 'slug';
    }
}
