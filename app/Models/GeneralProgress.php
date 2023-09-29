<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'progressable_id',
        'progressable_type',
        'date',
        'situation',
    ];

    public function progressable()
    {
        return $this->morphTo();
    }
}
