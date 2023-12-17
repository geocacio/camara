<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChamberFinancial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'description',
        'date',
        'slug',
    ];

    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function getRouteKeyName()
    {
        return 'slug';
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
}
