<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    use HasFactory;

    protected $fillable = [
        'secretary_id',
        'office_id',
        'number',
        'ordinance_date',
        'agent',
        'organization_company',
        'city',
        'state',
        'trip_start',
        'trip_end',
        'payment_date',
        'unit_price',
        'quantity',
        'amount',
        'justification',
        'historic',
        'information',
        'slug',
    ];
    
    public function categories()
    {
        return $this->morphMany(CategoryContent::class, 'categoryable');
    }
    
    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function secretaries()
    {
        return $this->belongsTo(Secretary::class, 'secretary_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function dailyPage()
    {
        return $this->belongsTo(DailyPage::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
