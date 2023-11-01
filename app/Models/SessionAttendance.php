<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionAttendance extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'councilor_id',
        'session_id',
        'call',
    ];

    public function councilor()
    {
        return $this->belongsTo(Councilor::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
