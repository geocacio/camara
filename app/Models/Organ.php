<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organ extends Model
{
    use HasFactory;

    public function contentRelation()
    {
        return ['employee', 'employee_id'];
    }

    protected $fillable = [
        'secretary_id',
        'name',
        'cnpj',
        'phone1',
        'phone2',
        'email',
        'business_hours',
        'address',
        'zip_code',
        'status',
        'description',
        'slug',
    ];

    public function secretary()
    {
        return $this->belongsTo(Secretary::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function employee()
    {
        return $this->morphOne(EmployeeContent::class, 'employeeable');
    }

    public function getAllEmployees()
    {
        $employees = collect();
        foreach ($this->departments as $department) {
            foreach ($department->sectors as $sector) {
                if ($sector->employees) {
                    foreach ($sector->employees as $employeeContent) {
                        $employees->push($employeeContent->employee);
                    }
                }
            }
        }
        return $employees;
    }



    public function getRouteKeyName()
    {
        return 'slug';
    }
}
