<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transactionable_id',
        'transactionable_type',
        'date',
        'session',
        'expedient',
        'stage',
        'status',
        'observation',
        'slug',
    ];

    public function transactionable()
    {
        return $this->morphTo();
    }
    
    public static function uniqSlugByYearId()
    {
        $countId = self::max('id');
        $nextId = $countId ? $countId + 1 : 1;
        $year = date('Y');
        $slug = $year . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
        return $slug;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
