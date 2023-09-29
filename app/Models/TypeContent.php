<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeContent extends Model
{
    use HasFactory;
    
    protected $fillable = ['type_id', 'typeable_id', 'typeable_type'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function content()
    {
        return $this->morphTo();
    }
}
