<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidding extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'modality',
        'opening_date',
        'status',
        'estimated_value',
        'description',
        'address',
        'city',
        'state',
        'country',
        'slug',
    ];

    public function secretary()
    {
        return $this->belongsTo(Secretary::class, 'secretary_id');
    }

    public function categories()
    {
        return $this->morphMany(CategoryContent::class, 'categoryable');
    }

    public function types()
    {
        return $this->morphToMany(Type::class, 'typeable', 'type_contents');
    }

    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }
    
    public function responsibilities()
    {
        return $this->belongsToMany(Category::class, 'bidding_responsibility_employee', 'bidding_id', 'responsibility_id')
            ->withPivot('employee_id')
            ->using(ResponsibilityEmployee::class);
    }

    public function publicationForms(){
        return $this->hasMany(PublicationForm::class);
    }

    public function company(){
        return $this->hasOne(Company::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
