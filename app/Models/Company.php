<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'bidding_id',
        'name',
        'cnpj',
        'address',
        'city',
        'state',
        'country',
        'slug',
    ];

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
