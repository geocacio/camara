<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExecutiveBoard extends Model
{
    use HasFactory;

    protected $fillable = [
        'councilor_id',
        'office',
    ];

    public function councilor()
    {
        return $this->belongsTo(Councilor::class);
    }
}
