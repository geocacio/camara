<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'status_id',
        'exercicy_id',
        'description',
        'slug',
    ];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function exercicy()
    {
        return $this->belongsTo(Category::class, 'exercicy_id');
    }

    public function status()
    {
        return $this->belongsTo(Category::class, 'status_id');
    }
    
    public function types()
    {
        return $this->morphToMany(Type::class, 'typeable', 'type_contents');
    }

    public function commissionLinks()
    {
        return $this->morphMany(CommissionLink::class, 'linkable');
    }

    public function sessionAttendance(){
        return $this->hasMany(SessionAttendance::class);
    }

    public function proceedings(){
        return $this->hasMany(Proceeding::class);
    }
    
    public static function uniqSlug()
    {
        $countId = self::max('id');
        $nextId = $countId ? $countId + 1 : 1;
        $year = date('Y');
        $slug = $year . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
        return $slug;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
