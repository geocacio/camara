<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransparencyGroupContent extends Model
{
    use HasFactory;

    protected $fillable = ['transparency_group_id', 'pageable_type', 'pageable_id'];

    public function transparencyGroup()
    {
        return $this->belongsTo(TransparencyGroup::class);
    }

    public function pageable()
    {
        return $this->morphTo();
    }
}
