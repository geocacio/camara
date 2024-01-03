<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionCouncilor extends Model
{
    use HasFactory;

    protected $fillable = [
        'commission_id',
        'councilor_id',
        'legislature_id',
        'office_id',
        'start_date',
        'end_date',
    ];

    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }

    public function councilor()
    {
        return $this->belongsTo(Councilor::class);
    }
}
