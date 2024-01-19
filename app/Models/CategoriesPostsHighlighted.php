<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesPostsHighlighted extends Model
{
    use HasFactory;

    protected $fillable = ['category_id'];
}
