<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'information',
        'slug',
    ];
    
    public function types()
    {
        return $this->morphToMany(Type::class, 'typeable', 'type_contents');
    }

    public function linkedCommittees()
    {
        return $this->hasMany(LinkedCommittee::class, 'commission_id');
    }

    public function commissionLinks()
    {
        return $this->hasMany(CommissionLink::class);
    }

    public function sessions()
    {
        return $this->morphToMany(Session::class, 'linkable', 'commission_links', 'linkable_id', 'linkable_type')
            ->where('linkable_type', Session::class);
    }

    public function materials()
    {
        return $this->morphToMany(Material::class, 'linkable', 'commission_links', 'linkable_id', 'linkable_type')
            ->where('linkable_type', Material::class);
    }

    public function members()
    {
        return $this->morphToMany(Member::class, 'linkable', 'commission_links', 'linkable_id', 'linkable_type')
            ->where('linkable_type', Member::class);
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
