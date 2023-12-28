<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class officehour extends Model
{
    use HasFactory;

    protected $fillable = [
        'information',
        'frequency',
        'responsible_name',
        'responsible_position',
        'entity_name',
        'entity_address',
        'entity_zip_code',
        'entity_cnpj',
        'entity_email',
        'entity_phone',
    ];
}
