<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialJournal extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status', 'content', 'summary', 'publication_date', 'created_at'];

    public function user(){
        return $this->hasOne(User::class);
    }
    
    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function publications()
    {
        return $this->hasMany(SecretaryPublication::class, 'diary_id');
    }
}
