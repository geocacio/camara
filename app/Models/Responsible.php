<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'responsible_id', 'responsibleable_type', 'responsibleable_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    
    public function responsibleable()
    {
        return $this->morphTo();
    }
}
