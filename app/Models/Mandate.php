<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Mandate extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'relationship',
        'legislature',
        'period',
    ];

    public function councilor(){
        return $this->belongsTo(Councilor::class);
    }

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

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
