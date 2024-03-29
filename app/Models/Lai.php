<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lai extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 
        'state_lai',
        'federal_lai',
    ];

    public static function uniqSlug($name)
    {
        $slug = Str::slug($name);

        $count = self::where('slug', $slug)->count();

        if ($count > 0) {
            $newSlug = $slug . '-' . ($count + 1);

            while (self::where('slug', $newSlug)->count() > 0) {
                $count++;
                $newSlug = $slug . '-' . ($count + 1);
            }

            return $newSlug;
        }

        return $slug;
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'law_id');
    }

    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
