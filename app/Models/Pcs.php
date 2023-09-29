<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pcs extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercicy_id',
        'manager',
        'date',
        'audit_court_situation',
        'court_accounts_date',
        'slug',
    ];

    public function exercicy()
    {
        return $this->belongsTo(Category::class, 'exercicy_id');
    }
    
    public function files()
    {
        return $this->morphMany(FileContent::class, 'fileable');
    }

    public function types()
    {
        return $this->morphToMany(Type::class, 'typeable', 'type_contents');
    }

    public static function uniqSlugByYearId()
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
