<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OmbudsmanSurvey extends Model
{
    use HasFactory;

    protected $fillable = ['cpf'];

    public function responses()
    {
        return $this->hasMany(OmbudsmanResponse::class);
    }
}
