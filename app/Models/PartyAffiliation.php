<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PartyAffiliation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'acronym',
        'slug',
    ];
    
    public function councilor(){
        return $this->belongsTo(Councilor::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
