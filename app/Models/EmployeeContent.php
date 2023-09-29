<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeContent extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'employeeable_type', 'employeeable_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    
    public function employeeable()
    {
        return $this->morphTo();
    }
}
