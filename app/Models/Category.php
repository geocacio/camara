<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id', 'slug'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public static function getParentCategories()
    {
        return self::with('children')->whereNull('parent_id')->get();
    }

    public static function getParentCategoryById($id)
    {
        return self::with('children')->where('id', $id)->whereNull('parent_id')->get();
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function categoryContents()
    {
        return $this->hasMany(CategoryContent::class);
    }

    public function biddings()
    {
        return $this->belongsToMany(Bidding::class, 'bidding_responsibility_employee', 'responsibility_id', 'bidding_id')
            ->withPivot('employee_id')
            ->using(ResponsibilityEmployee::class);
    }
    
    public function publications() {
        return $this->hasMany(SecretaryPublication::class, 'summary_id');
    }
    
    public function fav() {
        return $this->hasOne(CategoriesPostsHighlighted::class, 'category_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
