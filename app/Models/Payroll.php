<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercicy_id',
        'competency_id',
        'type_leaf_id',
        'earnings',
        'calculate_earnings',
        'deductions',
        'calculate_deductions',
        'net_pay',
        'calculate_net_pay',
        'slug',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function exercicy()
    {
        return $this->belongsTo(Category::class, 'exercicy_id');
    }

    public function competency()
    {
        return $this->belongsTo(Category::class, 'competency_id');
    }

    public function typeLeaf()
    {
        return $this->belongsTo(Category::class, 'type_leaf_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
