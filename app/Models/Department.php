<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function contentRelation() {
        return ['employee', 'employee_id'];
    }

    protected $fillable = ['secretary_id', 'organ_id', 'name', 'email', 'phone1', 'phone2', 'zip_code', 'address', 'business_hours', 'description', 'slug'];

    public function organ()
    {
        return $this->belongsTo(Organ::class);
    }

    public function secretary()
    {
        return $this->belongsTo(Secretary::class);
    }

    public function sectors(){
        return $this->hasMany(Sector::class);
    }
    
    public function employee()
    {
        return $this->morphOne(EmployeeContent::class, 'employeeable');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
