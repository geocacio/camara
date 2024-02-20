<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'url', 'format', 'size'];

    public function fileContents()
    {
        return $this->hasMany(FileContent::class);
    }
}
