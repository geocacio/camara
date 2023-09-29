<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'system_name',
        'phone',
        'cnpj',
        'cep',
        'address',
        'number',
        'neighborhood',
        'city',
        'state',
    ];

    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }
}
