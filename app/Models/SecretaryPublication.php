<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecretaryPublication extends Model
{
    use HasFactory;

    protected $fillable = [
        'diary_id',
        'secretary_id',
        'summary_id',
        'title',
        'column',
        'content',
        'publication_date',
        'slug',
    ];

    public function secretary()
    {
        return $this->belongsTo(Secretary::class);
    }

    public function summary()
    {
        return $this->belongsTo(Category::class);
    }

    public function diary()
    {
        return $this->belongsTo(OfficialJournal::class, 'diary_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
