<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionMeasurements extends Model
{
    use HasFactory;

    protected $fillable = [
        'responsible_execution',
        'responsible_supervision',
        'folder_manager',
        'first_date',
        'end_date',
        'situation',
        'invoice',
        'invoice_date',
        'price',
        'slug',
    ];

    public function constructions()
    {
        return $this->belongsTo(Construction::class);
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
