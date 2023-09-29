<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'bidding_id',
        'type',
        'description',
        'date',
        'slug',
    ];

    public function biddings(){
        return $this->belongsTo(Bidding::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
