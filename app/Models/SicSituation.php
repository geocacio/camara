<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SicSituation extends Model
{
    use HasFactory;
    
    protected $fillable = ['sic_solicitation_id', 'situation'];

    public function solicitation()
    {
        return $this->belongsTo(SicSolicitation::class, 'sic_solicitation_id');
    }
}
