<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCharter extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'service_hours',
        'service_completion_time',
        'user_cost',
        'service_provision_methods',
        'service_steps',
        'requirements_documents',
        'links',
        'views',
        'rating',
    ];
}
