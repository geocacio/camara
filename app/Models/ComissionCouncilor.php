<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComissionCouncilor extends Model
{
    use HasFactory;

    protected $fillable = [
        'comission_id',
        'councilor_id',
    ];

    public function comission()
    {
        return $this->belongsTo(Commission::class);
    }

    public function councilor()
    {
        return $this->belongsTo(Councilor::class);
    }
}
