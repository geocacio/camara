<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'signature_date',
        'expiry_date',
        'bidding_process',
        'company_id',
        'exercicio_id',
        'slug',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }
    
    public function categories()
    {
        return $this->morphMany(CategoryContent::class, 'categoryable');
    }

    public function getRouteKeyName(){
        return 'slug';
    }
}
