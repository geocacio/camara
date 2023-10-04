<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ContentStyle;
use App\Models\Link;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Style;
use App\Models\Type;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cores = [
            'bgn' => '#050505', //menu e footer
            'bgn1' => '#000000', //menu top
            'bgn2' => '#111111', //fundo (section)
            'bgn3' => '#1f1f1f', //cards
            'bgn4' => '#262626', //cards
            'btnn1' => '#1b1c1e',
            'cn' => '#e8eaed'
        ];

        //Cria categorias padrão
        $categories = ['Posts', 'Vídeos', 'Modalidades', 'Concorrência', 'Responsabilidades', 'Sumario', 'Arquivos Disponíveis'];
        foreach($categories as $category){
            Category::firstOrCreate([
                'name' => $category,
                'slug' => Str::slug($category)
            ]);
        }
        //Cria os tipos padrão
        $types = ['LRFs', 'Contracts', 'Biddings', 'PCG', 'Sessions', 'Commissions', 'Agreements', 'Constructions', 'Constructions ART'];
        foreach($types as $type){
            Type::firstOrCreate([
                'name' => $type,
                'slug' => Str::slug($type)
            ]);
        }
        
        DB::table('transparency_group_contents')->truncate();

        $menus = [
            [
                'menu' => 'Menu Principal',
                'styles' => [
                    'classes' => [
                        '.custom-menu' => [
                            'background_color' => '#30358c',
                            'background_color_night' => $cores['bgn'],
                        ],
                        '.custom-menu .dropdown-menu' => [
                            'background_color' => '#30358c',
                            'background_color_night' => $cores['bgn'],
                        ],                        
                        '.custom-menu .navbar-nav .nav-item .nav-link' => [
                            'title_color' => '#ffffff',
                            'title_size' => '13',
                            'title_color_night' => $cores['cn'],
                        ],
                        '.custom-menu .navbar-nav .nav-item .nav-link:hover' => [
                            'background_color' => '#242768',
                            'background_color_night' => '#18191a',
                            'title_color' => '#ffffff',
                            'title_color_night' => $cores['cn'],
                        ],
                        '.custom-menu .dropdown-menu li a' => [
                            'title_color' => '#ffffff',
                            'title_size' => '13',
                            'title_color_night' => $cores['cn'],
                        ],
                        '.custom-menu .dropdown-menu li a:hover' => [
                            'background_color' => '#242768',
                            'background_color_night' => '#18191a',
                            'title_color' => '#ffffff',
                            'title_color_night' => $cores['cn'],
                        ],
                    ]
                ],
                'links' => [
                    [
                        'name' => null,
                        'icon' => 'fa fa-home fa-lg',
                        'type' => 'link',
                        'url' => '/',
                    ],
                    // [
                    //     'name' => 'O município',
                    //     'icon' => null,
                    //     'type' => 'dropdown',
                    //     'url' => null
                    // ],
                    // [
                    //     'name' => 'A Prefeitura',
                    //     'icon' => null,
                    //     'type' => 'dropdown',
                    //     'url' => null
                    // ],
                    // [
                    //     'name' => 'Governo eletrônico',
                    //     'icon' => null,
                    //     'type' => 'dropdown',
                    //     'url' => null
                    // ],
                    // [
                    //     'name' => 'Secretarias',
                    //     'icon' => null,
                    //     'type' => 'dropdown',
                    //     'url' => null
                    // ],
                    // [
                    //     'name' => 'Gestão fiscal',
                    //     'icon' => null,
                    //     'type' => 'dropdown',
                    //     'url' => null
                    // ],
                    // [
                    //     'name' => 'Serviços',
                    //     'icon' => null,
                    //     'type' => 'dropdown',
                    //     'url' => null
                    // ],
                    // [
                    //     'name' => 'Publicações',
                    //     'icon' => null,
                    //     'type' => 'dropdown',
                    //     'url' => null
                    // ]
                ]
            ],
            [
                'menu' => 'Menu do Rodapé',
                'styles' => [
                    'background_color' => '#30358c',
                    'background_color_night' => $cores['bgn2'],
                    'title_color' => '#ffffff',
                    'title_color_night' => $cores['cn'],
                    'button_text_color' => '#ffffff',
                    'button_text_color_night' => '#ffffff',
                    'button_text_size' => '13',
                    'button_background_color' => '#3F45B6',
                    'button_background_color_night' => $cores['btnn1'],
                ]
            ],
            [
                'menu' => 'Menu do Topo',
                'styles' => [
                    'classes' => [
                        '#menu-topo' => [
                            'background_color' => '#004080',
                            'background_color_night' => $cores['bgn1'],
                        ],
                        '#menu-topo .menu-topo .menu-item .menu-link' => [
                            'title_color' => '#ffffff',
                            'title_size' => '13',
                            'title_color_night' => $cores['cn'],
                        ],
                        '#menu-topo .menu-topo .menu-item .menu-link:hover' => [
                            'background_color' => '#033464',
                            'background_color_night' => $cores['bgn4'],
                            'title_color' => '#ffffff',
                            'title_color_night' => $cores['cn'],
                        ],
                    ]
                ],
                'links' => [
                    [
                        'name' => 'Contraste',
                        'icon' => 'fa fa-adjust',
                        'type' => 'button',
                        'url' => null,
                    ],
                    [
                        'name' => 'Aumentar',
                        'icon' => 'fa fa-plus-square-o',
                        'type' => 'button',
                        'url' => null,
                    ],
                    [
                        'name' => 'Diminuir',
                        'icon' => 'fa fa-minus-square-o',
                        'type' => 'button',
                        'url' => null,
                    ],
                    [
                        'name' => 'Restaurar',
                        'icon' => 'fa-solid fa-rotate-right',
                        'type' => 'button',
                        'url' => null,
                    ],
                ]
                ],
                // [
                //     'menu' => 'Menu de redes Sociais',
                //     'styles' => [
                //         'classes' => [
                //             '.social-media' => [
                //                 'background_color' => '#242768',
                //                 'background_color_night' => $cores['bgn1'],
                //             ],
                //             '.social-media .menu-social-media .item .link' => [
                //                 'title_color' => '#ffffff',
                //                 'title_size' => '13',
                //                 'title_color_night' => $cores['cn'],
                //                 'background_color' => '#3F45B6',
                //                 'background_color_night' => $cores['bgn2'],
                //             ],
                //             '.social-media .menu-social-media .item .link:hover' => [
                //                 'background_color' => '#32368f',
                //                 'background_color_night' => $cores['bgn4'],
                //                 'title_color' => '#ffffff',
                //                 'title_color_night' => $cores['cn'],
                //             ],
                //         ]
                //     ],
                // ]
        ];

        $menuIds = [];
        foreach ($menus as $menuData) {
            $newMenu = Menu::create(['name' => $menuData['menu'], 'slug' => Str::slug($menuData['menu'])]);

            if ($menuData['menu'] != 'Menu do Topo') {
                $menuIds[] = $newMenu->id;
            }

            $styleData = $menuData['styles'];
            if (isset($styleData['classes'])) {
                foreach ($styleData['classes'] as $class => $classStyles) {
                    $classStyles['classes'] = $class;
                    $style = new Style($classStyles);
                    $newMenu->styles()->save($style);
                }
            }

            // Criar os links do menu, se existirem
            if (isset($menuData['links'])) {
                foreach ($menuData['links'] as $key => $linkData) {
                    
                    $link = Link::create([
                        'name' => $linkData['name'],
                        'icon' => $linkData['icon'],
                        'type' => $linkData['type'],
                        'url' => $linkData['url'],
                        'slug' => Str::slug($linkData['name'] ? $linkData['name'] : $linkData['icon'])
                        // Adicione os outros campos relevantes aqui
                    ]);
                    $position = $key + 1;
                    $newMenu->links()->attach($link, ['position' => $position]);
                }
            }
        }

        //Cria todas as páginas
        $data = require __DIR__ . '/siteData.php';
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

        //Criar Sessões (como serviços, post e etc)
        $contents = require __DIR__ . '/sectionsData.php';
        foreach ($contents as $content) {
            // echo $content['content'] . ' - ';
            $newContent = ContentStyle::create(['model' => $content['content']]);
            if (isset($content['styles'])) {
                $styleData = $content['styles'];
                // Verificar se existem classes definidas para o estilo
                if (isset($styleData['classes'])) {
                    foreach ($styleData['classes'] as $class => $classStyles) {
                        $classStyles['classes'] = $class;
                        // echo 'passou aqui - ';
                        $style = new Style($classStyles);
                        $newContent->styles()->save($style);
                    }
                }
            }
        }
    }
}
