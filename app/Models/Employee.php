<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'office_id',
        'email',
        'phone',
        'cpf',
        'dependents',
        'admission_date',
        'employment_type',
        'status',
        'slug',
        'secretary_id',
        'contact_number',
        'credor',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function employeeContent()
    {
        return $this->belongsTo(EmployeeContent::class);
    }

    public function responsibilities()
    {
        return $this->belongsToMany(Category::class, 'bidding_responsibility_employee', 'employee_id', 'responsibility_id')
            ->withPivot('bidding_id')
            ->using(ResponsibilityEmployee::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function responsible()
    {
        return $this->hasOne(Responsible::class, 'employee_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
