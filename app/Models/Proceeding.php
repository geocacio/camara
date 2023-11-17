<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceeding extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'type_id',
    ];

    public function sessions(){
        return $this->belongsTo(Session::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'type_id');
    }
}