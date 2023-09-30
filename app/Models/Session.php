<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'status_id',
        'exercicy_id',
        'description',
        'slug',
    ];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function exercicy()
    {
        return $this->belongsTo(Category::class, 'exercicy_id');
    }

    public function status()
    {
        return $this->belongsTo(Category::class, 'status_id');
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
