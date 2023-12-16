<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'commission_id',
        'material_id',
    ];

    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
