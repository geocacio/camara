<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SicSolicitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'receive_in',
        'title',
        'solicitation',
        'protocol',
        'slug',
    ];

    public function situations()
    {
        return $this->hasMany(SicSituation::class);
    }

    public function responseTimes()
    {
        return $this->hasMany(SicResponseTime::class);
    }

    public function latestResponseTime()
    {
        return $this->hasOne(SicResponseTime::class)->latest('response_deadline');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function secretary()
    {
        return $this->belongsTo(Secretary::class);
    }

    public function user()
    {
        return $this->belongsTo(SicUser::class);
    }
}
