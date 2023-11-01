<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Page;
use App\Models\Section;
use App\Models\Style;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaveStylesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = require __DIR__ . '/siteData.php';
        DB::table('styles')->truncate();
        $pages = Page::all();

        foreach ($pages as $page) {
            // Remover todas as seções associadas à página
            
            // Remover todos os links associados à página
            foreach ($page->links as $link) {
                // Remover todos os menu_links associados ao link
                $link->menus()->detach();
                $link->delete();
            }
            $page->sections()->delete();
        
            // Remover a própria página
            // $page->delete();
        }

        foreach ($data as $pageData) {
            $page = Page::firstOrCreate([
                'name' => $pageData['page'],
            ], [
                'route' => $pageData['route'],
                'slug' => Str::slug($pageData['page'])
            ]);

            //Cria o link da página
            $link = Link::firstOrCreate([
                'name' => $page->name,
                'target_id' => $page->id,
                'type' => 'link',
                'route' => $page->route,
                'target_type' => 'page',
                'slug' => Str::slug($pageData['page'])
            ]);

            //Cria as sessões das páginas
            if (isset($pageData['sections'])) {
                foreach ($pageData['sections'] as $key => $section) {
                    $newSection = $page->sections()->create([
                        "page_id" => $page->id,
                        "component" => $section['component'],
                        "name" => $section['name'],
                        "position" => $key + 1,
                        "visibility" => 'enabled',
                        "slug" => Str::slug($section['name'])
                    ]);
                    if (isset($section['styles'])) {
                        $styleData = $section['styles'];
                        // Verificar se existem classes definidas para o estilo
                        if (isset($styleData['classes'])) {
                            foreach ($styleData['classes'] as $class => $classStyles) {
                                $classStyles['classes'] = $class;
                                $style = new Style($classStyles);
                                $newSection->styles()->save($style);
                            }
                        }
                    }
                }
            }
        }

        
    $this->call(GenerateStyleSCSSSeeder::class);

    }
}
