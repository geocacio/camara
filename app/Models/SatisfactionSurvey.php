<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatisfactionSurvey extends Model
{
    use HasFactory;

    protected $fillable = ['satisfaction_level', 'page_name', 'name', 'email', 'description'];

    public function pageable()
    {
        return $this->morphTo('pageable');
    }
}
