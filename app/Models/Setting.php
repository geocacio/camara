<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'system_name',
        'plenary',
        'phone',
        'email',
        'cnpj',
        'cep',
        'address',
        'number',
        'neighborhood',
        'city',
        'opening_hours',
        'state',
    ];

    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }
}
