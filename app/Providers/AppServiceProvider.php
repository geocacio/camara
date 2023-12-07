<?php

namespace App\Providers;

use App\Models\Legislature;
use App\Models\Menu;
use App\Models\Section;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\ViewComposers\GlobalDataComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        Paginator::defaultView('panel.pagination.custom');

        Relation::enforceMorphMap([
            'page' => 'App\Models\Page',
            'post' => 'App\Models\Post',
            'menu' => 'App\Models\Menu',
            'section' => 'App\Models\Section',
            'lrf' => 'App\Models\LRF',
            'ordinance' => 'App\Models\Ordinance',
            'daily' => 'App\Models\Daily',
            'law' => 'App\Models\Law',
            'secretary' => 'App\Models\Secretary',
            'decrees' => 'App\Models\Decrees',
            'video' => 'App\Models\Video',
            'bidding' => 'App\Models\Bidding',
            'contract' => 'App\Models\Contract',
            'employee' => 'App\Models\Employee',
            'organ' => 'App\Models\Organ',
            'department' => 'App\Models\Department',
            'sector' => 'App\Models\Sector',
            'official_journals' => 'App\Models\OfficialJournal',
            'configure_official_diary' => 'App\Models\ConfigureOfficialDiary',
            'setting' => 'App\Models\Setting',
            'content_style' => 'App\Models\ContentStyle',
            'service_letter' => 'App\Models\ServiceLetter',
            'transparency_group' => 'App\Models\TransparencyGroup',
            'transparency_portal' => 'App\Models\TransparencyPortal',
            'external_link' => 'App\Models\ExternalLink',
            'publication' => 'App\Models\Publication',
            'selective_process' => 'App\Models\SelectiveProcess',
            'ombudsman_page' => 'App\Models\OmbudsmanPage',
            'manager' => 'App\Models\Manager',
            'symbol' => 'App\Models\Symbols',
            'Agreement' => 'App\Models\Agreement',
            'GeneralContract' => 'App\Models\GeneralContract',
            'Construction' => 'App\Models\Construction',
            'ConstructionArt' => 'App\Models\ConstructionArt',
            'Pcg' => 'App\Models\Pcg',
            'Pcs' => 'App\Models\Pcs',
            'Session' => 'App\Models\Session',
            'Councilor' => 'App\Models\Councilor',
            'Commission' => 'App\Models\Commission',
            'Material' => 'App\Models\Material',
            'Banner' => 'App\Models\Banner',
        ]);


        try {

            //exibir o map com base nesta busca
            $showMap = Section::where('name', 'Mapa do site')->select('visibility')->first();
            view::share('showMap', $showMap);
            
            $legislature = new Legislature();
            $currentPresident = $legislature->getCurrentPresident();
            view::share('currentPresident', $currentPresident);
            
            $settings = Setting::first();
            $logoFooterImage = null;
            
            if($settings){
                $logoFooterImage = $settings->files()->whereHas('file', function ($query) {
                    $query->where('name', 'Logo Footer');
                })->first();
                view::share('settings', $settings);
            }
            
            $logo_footer = $logoFooterImage ? $logoFooterImage->file->url : null;
            view::share('logo_footer', $logo_footer);
            
            $getMenus = Menu::with(['styles', 'links' => function ($query) {
                $query->orderBy('position')->with('group');
            }])->get();
            
            $menus = [];
            foreach ($getMenus as $menu) {
                if ($menu->name == 'Menu Principal') {
                    $menus['menuPrincipal'] = $menu;
                }
                if ($menu->name == 'Menu do Rodapé') {
                    $menus['menuRodape'] = $menu;
                }
                if ($menu->name == 'Menu do Topo') {
                    $menus['menuTopo'] = $menu;
                }
                if ($menu->name == 'Menu de redes Sociais') {
                    $menus['menuRedeSocial'] = $menu;
                }
            }
            
            View::share('menus', $menus);

        } catch (\Illuminate\Database\QueryException  $e) {
            error_log('* Waiting for the database to have contacts and about tables');
        }
        
        view()->composer('*', GlobalDataComposer::class);
    }
}
