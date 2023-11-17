<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialsProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'proceeding_id',
        'phase',
        'observations',
    ];
}
