<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'councilor_id',
        'session_id',
        'date',
        'status',
        'exercise',
        'description',
        'views',
        'slug',
    ];

    public function categories()
    {
        return $this->morphMany(CategoryContent::class, 'categoryable');
    }

    public function councilor()
    {
        return $this->belongsTo(Councilor::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function authors()
    {
        return $this->hasMany(Author::class);
    }

    public function recipients()
    {
        return $this->hasMany(Recipient::class);
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function commissionLinks()
    {
        return $this->morphMany(CommissionLink::class, 'linkable');
    }
    
    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
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
