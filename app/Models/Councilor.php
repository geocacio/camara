<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Councilor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'office_id',
        'bond_id',
        'start_bond',
        // 'end_mandate',
        'birth_date',
        'biography',
        'profile_image',
        'slug',
    ];

    public function legislatureRelations()
    {
        return $this->morphMany(LegislatureRelation::class, 'legislatureable');
    }

    public function mandates(){
        return $this->hasMany(Mandate::class);
    }

    public function commissions(){
        return $this->hasMany(Commission::class);
    }

    public function partyAffiliations(){
        return $this->hasMany(PartyAffiliation::class);
    }

    public function materials(){
        return $this->hasMany(Material::class);
    }

    public function categories()
    {
        return $this->morphMany(CategoryContent::class, 'categoryable');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
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
