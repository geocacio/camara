<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon', 'target_id', 'target_type', 'slug', 'visibility', 'parent_id', 'type', 'url'];

    public function target()
    {
        return $this->morphTo();
    }

    public function group()
    {
        return $this->hasMany(Link::class, 'parent_id');
    }

    public function setGroup()
    {
        return $this->belongsTo(Link::class, 'parent_id');
    }


    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_links');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function getOnlyLinks()
    {
        return self::whereNull('parent_id')->whereNotIn('id', function ($query) {
            $query->select('parent_id')->from('links')->whereNotNull('parent_id');
        })->get();
    }

    public function getGroupAndLinksDisponiveis()
    {
        $linksDisponiveis = self::getOnlyLinks()->toArray();
        $linksDoGrupo = $this->group->toArray();

        return array_merge($linksDoGrupo, $linksDisponiveis);
    }

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }
}
