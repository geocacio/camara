<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    // public function contentRelation() {
    //     return ['responsible', 'employee_id'];
    // }

    protected $fillable = ['secretary_id', 'name', 'description', 'email', 'phone', 'slug'];

    // public function department()
    // {
    //     return $this->belongsTo(Department::class);
    // }
    
    public function employees()
    {
        return $this->morphMany(EmployeeContent::class, 'employeeable');
    }

    public function secretary()
    {
        return $this->belongsTo(Secretary::class);
    }
    
    // public function responsible()
    // {
    //     return $this->morphOne(Responsible::class, 'responsibleable');
    // }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
