<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Page;
use App\Models\Style;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageNormativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dayColors = [
            'main_menu' => '#004080',
            "main_menu_link_color" => "#ffffff",
            "main_menu_link_color_hover" => "#ffffff",
            "main_menu_link_bg_color" => "transparent",
            "main_menu_link_bg_color_hover" => "#033464",
            'bg_main_banner' => '#ffffff',
            'secondary_menu' => '#30358c',
            "secondary_menu_link_color" => "#ffffff",
            "secondary_menu_link_color_hover" => "#ffffff",
            "secondary_menu_link_bg_color" => "transparent",
            "secondary_menu_link_bg_color_hover" => "#242768",
            'footer_menu' => '#30358c',
            'bg_section' => '#e1e5e7',
            'bg_card_select' => '#e1e5e7',
            'bg_card_select_hover' => '#313131',
            'bg_section_survey' => '#ffffff',
            'bg_card' => '#ffffff',
            'title_color' => '#212529',
            'subtitle_color' => '#3c3e41',
            'subtitle_color_hover' => '#3c3e41',
            'text_color' => '#3c3e41',
            'link_color' => '#ffffff',
            'link_color_2' => '#00668b',
            'link_color_hover' => '#ffffff',
            'link_bg_color' => '#004080',
            'link_bg_color_2' => 'transparent',
            'link_bg_color_hover' => '#00668b',
            'transparent' => 'transparent',
            'bg_input' => '#ffffff',
            'input_text_color' => '#121212',
            'form_btn_color' => '#ffffff',
            'form_btn_color_hover' => '#ffffff',
            'form_btn_bg_color' => '#3c42a7',
            'form_btn_bg_color_hover' => '#004080',
            'network_link_color' => '#30358c',
            'network_link_color_hover' => '#ffffff',
            'network_link_bg_color' => '#e7e7e7',
            'network_link_bg_color_hover' => '#004080',
            'breadcrumb_color' => '#0e6fc5',
            'breadcrumb_color_span' => '#6c757d',
            'ombudsman_color_1' => '#00668b',
            'ombudsman_color_2' => '#FEA101',
            'ombudsman_color_3' => '#e52529',
            'card_with_link' => '#121212',
            'card_with_link_text' => '#0c0c0c',
            'ombudsman_menu_link_color' => '#373c9b',
            'ombudsman_menu_link_color_active' => '#373c9b',
            'ombudsman_menu_link_bg_color' => 'transparent',
            'ombudsman_menu_link_bg_color_active' => '#dbdced',
            'table_bg_color' => '#ffffff',
            'thead_table_color' => '#ffffff',
            'thead_table_bg_color' => '#00668b',
            'td_table_color' => '#454545',
            'caption_table_color' => '#212529',
            'caption_table_bg_color' => '#e1e5e7',
            'btn_caption_color' => '#ffffff',
            'btn_caption_bg' => '#00668b',
            'table_btn_color' => '#00668b',
            'table_btn_bg' => 'transparent',
            'table_btn_color_hover' => '#ffffff',
            'table_btn_bg_hover' => '#00668b',
        
            "Midnight Blue" => "#004080",
            "Pure White" => "#ffffff",
            "Navy Blue" => "#033464",
            "Blue-Green" => "#00668b",
            "Sapphire Blue" => "#30358c",
            "Royal Blue" => "#4248b3",
            "Pale Silver" => "#e1e5e7",
            "Steel Gray" => "#303030",
            "Slate Gray" => "#6c757d",
            "input_search" => "#e7e7e7",
        ];
        
        $darkColors = [
            'main_menu' => '#000000',
            "main_menu_link_color" => "#ffffff",
            "main_menu_link_color_hover" => "#ffffff",
            "main_menu_link_bg_color" => "transparent",
            "main_menu_link_bg_color_hover" => "#18191a",
            'bg_main_banner' => '#0c0c0c',
            'secondary_menu' => '#1f1f1f',
            "secondary_menu_link_color" => "#ffffff",
            "secondary_menu_link_color_hover" => "#ffffff",
            "secondary_menu_link_bg_color" => "transparent",
            "secondary_menu_link_bg_color_hover" => "#18191a",
            'footer_menu' => '#1f1f1f',
            'bg_section' => '#121212',
            'bg_card_select' => '#121212',
            'bg_card_select_hover' => '#313131',
            'bg_section_survey' => '#121212',
            'bg_card' => '#1e1e1e',
            'title_color' => '#e2e2e2',
            'subtitle_color' => '#e0e0e0',
            'subtitle_color_hover' => '#e0e0e0',
            'text_color' => '#9d9d9d',
            'link_color' => '#ffffff',
            'link_color_2' => '#ffffff',
            'link_color_hover' => '#ffffff',
            'link_bg_color' => '#3d4041',
            'link_bg_color_2' => 'transparent',
            'link_bg_color_hover' => '#2c2c2d',
            'transparent' => 'transparent',
            'bg_input' => '#3a3a3a',
            'input_text_color' => '#e1e1e1',
            'form_btn_color' => '#ffffff',
            'form_btn_color_hover' => '#ffffff',
            'form_btn_bg_color' => '#1f1f1f',
            'form_btn_bg_color_2' => '#121212',
            'form_btn_bg_color_hover' => '#09090a',
            'network_link_color' => '#ffffff',
            'network_link_color_hover' => '#ffffff',
            'network_link_bg_color' => 'transparent',
            'network_link_bg_color_hover' => '#3a3a3a',
            'breadcrumb_color' => '#0e6fc5',
            'breadcrumb_color_span' => '#6c757d',
            'ombudsman_color_1' => '#00668b',
            'ombudsman_color_2' => '#FEA101',
            'ombudsman_color_3' => '#e52529',
            'card_with_link' => '#1f1f1f',
            'card_with_link_text' => '#e0e0e0',
            'ombudsman_menu_link_color' => '#939393',
            'ombudsman_menu_link_color_active' => '#ffffff',
            'ombudsman_menu_link_bg_color' => 'transparent',
            'ombudsman_menu_link_bg_color_active' => '#151515',
            'table_bg_color' => '#1e1e1e',
            'thead_table_color' => '#e2e2e2',
            'thead_table_bg_color' => '#151515',
            'td_table_color' => '#e2e2e2',
            'caption_table_color' => '#e2e2e2',
            'caption_table_bg_color' => '#212121',
            'btn_caption_color' => '#ffffff',
            'btn_caption_bg' => '#151515',
            'table_btn_color' => '#ffffff',
            'table_btn_bg' => 'transparent',
            'table_btn_color_hover' => '#ffffff',
            'table_btn_bg_hover' => '#121212',
        
            "Midnight Charcoal" => "#1f1f1f",
            "Absolute Black" => "#000000",
            "Charcoal Black" => "#09090a",
            "Charcoal Gray" => "#3a3a3a",
            "Slate Gray" => "#121212",
            "Graphite" => "#1e1e1e",
            "Pearl White" => "#e1e1e1",
            "Silverstone Gray" => "#a5a5a5"
        ];

        $data = [
            [
                'page' => 'Normativas',
                'route' => 'diary.normative.page',
                'sections' => [
                    [
                        'component' => 'normative',
                        'name' => 'Normativas',
                        'styles' => [
                            'classes' => [
                                '.section-normative' => [
                                    'background_color' => $dayColors["bg_section"],
                                    'background_color_night' => $darkColors['bg_section'],
                                    'title_color' => $dayColors["text_color"],
                                    'title_color_night' => $darkColors['text_color'],
                                ],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'page' => 'Apresentação',
                'route' => 'diary.presentation.page',
                'sections' => [
                    [
                        'component' => 'presentation',
                        'name' => 'Apresentação',
                        'styles' => [
                            'classes' => [
                                '.section-presentation' => [
                                    'background_color' => $dayColors["bg_section"],
                                    'background_color_night' => $darkColors['bg_section'],
                                    'title_color' => $dayColors["text_color"],
                                    'title_color_night' => $darkColors['text_color'],
                                ],
                            ]
                        ]
                    ]
                ]
            ],
        ];
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
                                // dd($classStyles);
                                $classStyles['classes'] = $class;
                                $style = new Style($classStyles);
                                $newSection->styles()->save($style);
                            }
                        }
                    }
                }
            }
        }

    }
}
