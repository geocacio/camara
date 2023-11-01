<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'secretary_id',
        'category_id',
        'title',
        'description',
        'service_letters',
        'main_steps',
        'requirements',
        'completion_forecast',
        'opening_hours',
        'costs',
        'service_delivery_methods',
        'additional_information',
        'views',
        'slug',
    ];

    public function secretary()
    {
        return $this->belongsTo(Secretary::class);
    }
    
    public function categories()
    {
        return $this->morphMany(CategoryContent::class, 'categoryable');
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
