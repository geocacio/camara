<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionArt extends Model
{
    use HasFactory;

    protected $fillable = ['number', 'responsible', 'date', 'construction_id', 'slug'];

    public function constructions()
    {
        return $this->belongsTo(Construction::class);
    }

    public function types()
    {
        return $this->morphToMany(Type::class, 'typeable', 'type_contents');
    }

    public function generateRegistrationNumber()
    {
        $currentYear = date('Y');
        $randomNumber = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $registrationNumber = $currentYear . $randomNumber;
        return $registrationNumber;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
