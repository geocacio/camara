<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'parent_id',
        'number',
        'start_date',
        'end_date',
        'total_value',
        'description',
        'slug',
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function companies(){
        return $this->belongsTo(Company::class);
    }

    public function types()
    {
        return $this->morphToMany(Type::class, 'typeable', 'type_contents');
    }

    public function parent()
    {
        return $this->belongsTo(Contract::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Contract::class, 'parent_id');
    }

    public function files()
    {
        return $this->morphOne(FileContent::class, 'fileable');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
