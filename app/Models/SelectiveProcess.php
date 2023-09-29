<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectiveProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercicy_id',
        'description',
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
    
    public function exercicy()
    {
        return $this->belongsTo(Category::class, 'exercicy_id');
    }
}
