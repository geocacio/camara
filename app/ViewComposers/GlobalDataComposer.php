<?php

namespace App\ViewComposers;

use Illuminate\View\View;
use App\Models\Setting;

class GlobalDataComposer
{
    public function compose(View $view)
    {
        //Configurações do sistema
        $settings = Setting::first();
        $logo = '';
        $favicon = '';
        if (isset($settings->files) && $settings->files->count() > 0) {
            foreach ($settings->files as $files) {
                if ($files->file->name == 'Logo') {
                    $logo = $files->file;
                }
                if ($files->file->name == 'Favicon') {
                    $favicon = $files->file;
                }
            }
        }
        $view->with('settings', $settings);
        $view->with('logo', $logo);
        $view->with('favicon', $favicon);
    }
}
