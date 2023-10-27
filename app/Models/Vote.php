<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'councilor_id',
        'voteable_id',
        'voteable_type',
        'vote',
    ];

    public function councilors(){
        return $this->belongsTo(Councilor::class);
    }

    public function voteable()
    {
        return $this->morphTo();
    }
}
