<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegislatureRelation extends Model
{
    use HasFactory;

    protected $fillable = [
        'legislature_id',
        'legislatureable_id',
        'legislatureable_type',
    ];

    public function legislature()
    {
        return $this->belongsTo(Legislature::class);
    }

    public function legislatureable()
    {
        return $this->morphTo();
    }
}
