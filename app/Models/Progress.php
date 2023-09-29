<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
        'bidding_id',
        'title',
        'datetime',
        'description',
        'slug',
    ];

    public function bidding(){
        return $this->belongsTo(Bidding::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
