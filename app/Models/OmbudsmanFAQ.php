<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OmbudsmanFAQ extends Model
{
    use HasFactory;

    protected $table = 'ombudsman_faqs';

    protected $fillable = [
        'question',
        'answer',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
