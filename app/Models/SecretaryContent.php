<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecretaryContent extends Model
{
    use HasFactory;
    
    protected $fillable = ['secretary_id', 'secretaryable_id', 'secretaryable_type'];

    public function secretary()
    {
        return $this->belongsTo(Secretary::class);
    }

    public function content()
    {
        return $this->morphTo();
    }
}
