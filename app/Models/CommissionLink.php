<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionLink extends Model
{
    use HasFactory;

    protected $fillable = ['commission_id', 'linkable_id', 'linkable_type', 'start_date', 'end_date'];

    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }

    public function linkable()
    {
        return $this->morphTo();
    }
}