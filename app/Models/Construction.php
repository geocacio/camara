<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Construction extends Model
{
    use HasFactory;

    protected $fillable = [
        'secretary_id',
        'title',
        'description',
        'date',
        'local',
        'expected_date',
        'slug',
    ];

    public function generalContracts()
    {
        return $this->morphMany(GeneralContract::class, 'contractable');
    }

    public function types()
    {
        return $this->morphToMany(Type::class, 'typeable', 'type_contents');
    }

    public function secretary()
    {
        return $this->belongsTo(Secretary::class);
    }
    
    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function generalProgress()
    {
        return $this->morphMany(GeneralProgress::class, 'progressable');
    }

    public function measurements()
    {
        return $this->hasMany(ConstructionMeasurements::class);
    }

    public function arts()
    {
        return $this->hasMany(ConstructionArt::class);
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
