<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secretary extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abbreviation',
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

    public function contentRelation() {
        return ['responsible', 'employee_id'];
    }
    
    public function categories()
    {
        return $this->morphMany(CategoryContent::class, 'categoryable');
    }
    
    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
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
    
    public function responsible()
    {
        return $this->morphOne(Responsible::class, 'responsibleable');
    }

    public function secretaryContents()
    {
        return $this->hasMany(CategoryContent::class);
    }

    public function organs() {
        return $this->hasMany(Organ::class);
    }

    public function biddings()
    {
        return $this->hasMany(Bidding::class);
    }

    public function publications() {
        return $this->hasMany(SecretaryPublication::class);
    }

    public function schedules() {
        return $this->hasMany(Schedule::class);
    }

    public function getRouteKeyName(){
        return 'slug';
    }
}
