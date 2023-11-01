<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Agreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'sphere',
        'validity',
        'celebration',
        'bank_account',
        'instrument_number',
        'object',
        'counterpart',
        'transfer',
        'agreed',
        'grantor',
        'grantor_responsible',
        'convenent',
        'convenent_responsible',
        'justification',
        'goals',
        'visibility',
        'slug',
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

    public static function uniqSlugByYearId()
    {
        $countId = self::max('id');
        $nextId = $countId ? $countId + 1 : 1;
        $year = date('Y');
        $slug = $year . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
        return $slug;
    }

    public function generalProgress()
    {
        return $this->morphMany(GeneralProgress::class, 'progressable');
    }

    public function generalProgresses()
    {
        return $this->morphMany(GeneralProgress::class, 'progressable');
    }

    public function generalContracts()
    {
        return $this->morphMany(GeneralContract::class, 'contractable');
    }

    public function transfers()
    {
        return $this->hasMany(AgreementTransfer::class, 'agreement_id');
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
