<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OmbudsmanQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['question_text'];

    public function responses()
    {
        return $this->hasMany(OmbudsmanResponse::class);
    }
}
