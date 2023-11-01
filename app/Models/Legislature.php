<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legislature extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'slug',
    ];

    public function legislatureRelations()
    {
        return $this->hasMany(LegislatureRelation::class);
    }

    public function getCurrentLegislature()
    {
        $currentDate = Carbon::now();
        return $this->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->first();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
