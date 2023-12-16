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
        'party_affiliation_id',
        'affiliation_date',
        'birth_date',
        'biography',
        'slug',
    ];

    public function legislatureRelations()
    {
        return $this->morphMany(LegislatureRelation::class, 'legislatureable');
    }

    public function getLastLegislature()
    {
        return $this->legislatureRelations()->orderBy('final_period', 'desc')->first();
    }

    public function mandates()
    {
        return $this->hasMany(Mandate::class);
    }

    public function partyAffiliation()
    {
        return $this->belongsTo(PartyAffiliation::class, 'party_affiliation_id');
    }


    public function materials()
    {
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

    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function commissions()
    {
        return $this->belongsToMany(Commission::class, 'commission_councilors', 'councilor_id', 'commission_id')
            ->withPivot('legislature_id', 'start_date', 'end_date')
            ->withTimestamps();
    }

    public function authors()
    {
        return $this->hasMany(Author::class);
    }

    public function sessionAttendance()
    {
        return $this->hasMany(SessionAttendance::class);
    }
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function getCurrentCouncilors()
    {
        // Obtém a legislatura atual
        $legislature = (new Legislature)->getCurrentLegislature();

        if ($legislature) {
            return $this->whereHas('legislatureRelations', function ($query) use ($legislature) {
                $query->where('legislature_id', $legislature->id);
                //   ->where('bond_id', 19); // Verifique se a relação correta é usada
            })->get();
        }

        return collect([]);
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
