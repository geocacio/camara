<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectorContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'inspector_id',
        'contract_id',
    ];
}
