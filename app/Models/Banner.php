<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = ['link_id', 'type', 'color'];
    
    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }
    
    public function links()
    {
        return $this->belongsTo(Link::class, 'link_id');
    }
}
