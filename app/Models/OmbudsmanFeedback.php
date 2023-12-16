<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OmbudsmanFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'protocol',
        'anonymous',
        'name',
        'cpf',
        'date_of_birth',
        'sex',
        'level_education',
        'email',
        'phone_type',
        'phone',
        'subject',
        'nature',
        'message',
        'answer',
        'deadline',
        'new_deadline',
        'status',
    ];

    public function secretary(){
        return $this->belongsTo(Secretary::class);
    }
}
