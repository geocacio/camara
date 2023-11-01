<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkedCommittee extends Model
{
    use HasFactory;

    protected $fillable = [
        'commission_id',
        'office',
        'start_date',
        'end_date',
    ];

    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }
}
