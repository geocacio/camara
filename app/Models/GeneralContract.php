<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'contractable_type',
        'contractable_id',
        'parent_id',
        'number',
        'start_date',
        'end_date',
        'total_value',
        'description',
        'slug',
    ];

    public function types()
    {
        return $this->morphToMany(Type::class, 'typeable', 'type_contents');
    }

    public function contractable()
    {
        return $this->morphTo();
    }

    public static function generateContractNumber()
    {
        $date = now()->format('dmY');
        $countId = self::max('id');
        $nextId = $countId ? $countId + 1 : 1;
        $contractNumber = sprintf('%s%05d', $date, $nextId);
        return $contractNumber;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
