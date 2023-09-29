<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryContent extends Model
{
    use HasFactory;
    
    protected $fillable = ['category_id', 'categoryable_id', 'categoryable_type'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function content()
    {
        return $this->morphTo();
    }
}
