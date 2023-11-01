<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_id',
        'employee_id',
        'earnings',
        'deductions',
        'net_pay',
        'slug',
    ];
    
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
