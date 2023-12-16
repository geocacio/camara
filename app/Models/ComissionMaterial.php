<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComissionMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'comission_id',
        'material_id',
    ];

    public function comission()
    {
        return $this->belongsTo(Commission::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
