<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileContent extends Model
{
    use HasFactory;

    protected $fillable = ['file_id', 'fileable_type', 'fileable_id'];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function fileable()
    {
        return $this->morphTo();
    }
}
