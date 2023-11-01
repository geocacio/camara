<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;


class ResponsibilityEmployee extends Pivot
{
    protected $table = 'bidding_responsibility_employee';

    protected $fillable = [
        'bidding_id',
        'responsibility_id',
        'employee_id',
    ];

    public function bidding()
    {
        return $this->belongsTo(Bidding::class);
    }

    public function responsibility()
    {
        return $this->belongsTo(Category::class, 'responsibility_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
