<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'voteable_id',
        'voteable_type',
        'vote',
    ];

    public function voteable()
    {
        return $this->morphTo();
    }
}
