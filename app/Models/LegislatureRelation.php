<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LegislatureRelation extends Model
{
    use HasFactory;

    protected $fillable = [
        'legislature_id',
        'legislatureable_id',
        'office_id',
        'bond_id',
        'first_period',
        'final_period',
        'legislatureable_type',
    ];

    public function legislature()
    {
        return $this->belongsTo(Legislature::class);
    }

    // public function councilors()
    // {
    //     return $this->hasManyThrough(Councilor::class, LegislatureRelation::class, 'legislature_id', 'id', 'id', 'councilor_id');
    // }

    public function category()
    {
        return $this->belongsTo(Category::class, 'bond_id');
    }


    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function legislatureable()
    {
        return $this->morphTo();
    }
}
