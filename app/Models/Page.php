<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['name', 
        'route', 
        'main_title', 
        'title', 'icon', 
        'description', 
        'featured_title', 
        'featured_description', 
        'slug', 'visibility', 
        'link_type', 
        'url'
    ];

    public function links()
    {
        return $this->morphMany(Link::class, 'target');
    }

    public function groupContents()
    {
        return $this->morphOne(TransparencyGroupContent::class, 'pageable');
    }
    
    public function transparencyGroups(){
        return $this->hasMany(TransparencyGroup::class, 'transparency_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function laws()
    {
        return $this->hasMany(law::class);
    }
}
