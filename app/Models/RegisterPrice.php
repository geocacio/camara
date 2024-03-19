<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RegisterPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'signature_date',
        'expiry_date',
        'bidding_process',
        'company_id',
        'exercicio_id',
        'object',
        'slug',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function bidding()
    {
        return $this->belongsTo(Bidding::class, 'bidding_process');
    }

    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }
    
    public function categories()
    {
        return $this->morphMany(CategoryContent::class, 'categoryable');
    }

    public function getRouteKeyName(){
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
