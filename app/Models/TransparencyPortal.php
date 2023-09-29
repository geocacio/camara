<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransparencyPortal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug',
    ];

    public function transparencyGroups(){
        return $this->hasMany(TransparencyGroup::class, 'transparency_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
