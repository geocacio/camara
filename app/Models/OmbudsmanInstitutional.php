<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OmbudsmanInstitutional extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_title',
        'title',
        'descriptions',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
