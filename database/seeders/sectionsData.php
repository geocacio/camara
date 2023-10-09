<?php

$data = [
    [
        'content' => 'service',
        'styles' => [
            'classes' => [
                '.container-service' => [
                    'type_style' => 'Cor de fundo e cor do texto',
                    'name' => 'Caixa de Serviço',
                    'background_color' => '#e1e5e7',
                    'background_color_night' => '#1b1c1e',
                    'title_color' => '#303030',
                    'title_color_night' => '#ffffff',
                ],
                '.container-service:hover' => [
                    'type_style' => 'Efeito da cor de fundo e cor do texto',
                    'name' => 'Caixa de Serviço',
                    'background_color' => '#3F45B6',
                    'background_color_night' => '#1d1f42',
                    'title_color' => '#ffffff',
                    'title_color_night' => '#ffffff',
                ],

                '.container-service .description .title' => [
                    'type_style' => 'Cor do título',
                    'name' => 'Título',
                    'title_color' => '#303030',
                    'title_size' => '14',
                    'title_color_night' => '#ffffff',
                ],

                '.container-service:hover .description .title' => [
                    'name' => 'Título',
                    'type_style' => 'Efeito da cor do título',
                    'title_color' => '#ffffff',
                    'title_color_night' => '#ffffff',
                ],

                '.container-service .description .text' => [
                    'type_style' => 'Cor do texto',
                    'name' => 'Texto',
                    'button_text_color' => '#303030',
                    'button_text_color_night' => '#e8eaed',
                    'button_text_size' => '12',
                ],

                '.container-service:hover .description .text' => [
                    'type_style' => 'Efeito da cor do texto',
                    'name' => 'Texto',
                    'title_color' => '#ffffff',
                    'title_color_night' => '#ffffff',
                ],

                '.container-service i' => [
                    'type_style' => 'Cor do ícone',
                    'name' => 'Ícone',
                    'button_text_color' => '#303030',
                    'button_text_color_night' => '#c5c5c5',
                ],

                '.container-service:hover i' => [
                    'type_style' => 'Efeito da cor do ícone',
                    'name' => 'Ícone',
                    'title_color' => '#ffffff',
                    'title_color_night' => '#ffffff',
                ],
            ]
        ]
    ],
    [
        'content' => 'post',
        'styles' => [
            'classes' => [
                '.posts-container .post' => [
                    'type_style' => 'Cor de fundo',
                    'name' => 'Seção',
                    'background_color' => '#ffffff',
                    'background_color_night' => '#1b1c1e',
                ],
                '.posts-container .post .content .date' => [
                    'type_style' => 'Cor da data',
                    'name' => 'Data',
                    'title_color' => '#212529',
                    'title_color_night' => '#dbdbdb',
                ],
                '.posts-container .post .content .title' => [
                    'type_style' => 'Cor do título',
                    'name' => 'Título',
                    'title_color' => '#242768',
                    'title_color_night' => '#7276b9',
                ],
                '.posts-container .post .content .text' => [
                    'type_style' => 'Cor do texto',
                    'name' => 'Texto',
                    'title_color' => '#212529',
                    'title_color_night' => '#dbdbdb',
                ],
            ]
        ]
    ],
    [
        'content' => 'service_letter',
        'styles' => [
            'classes' => [
                '.main-style-list .item .link' => [
                    'type_style' => 'Cor de fundo do link',
                    'name' => 'Link',
                    'background_color' => '#30358c',
                    'background_color_night' => '#1b1c1e',
                ],
                '.main-style-list .item .link .title' => [
                    'type_style' => 'Cor do título',
                    'name' => 'Título',
                    'title_color' => '#303030',
                    'title_color_night' => '#dbdbdb',
                    'title_size' => '14',
                ],
                '.main-style-list .item .link .description' => [
                    'type_style' => 'Cor da descrição',
                    'name' => 'Descrição',
                    'title_color' => '#555555',
                    'title_color_night' => '#f7f7f7',
                    'title_size' => '13',
                ],

                '.main-style-list .item .link .additional-informations' => [
                    'type_style' => 'Cor do texto',
                    'name' => 'Informação adicional',
                    'title_color' => '#555555',
                    'title_color_night' => '#f7f7f7',
                    'title_size' => '13',
                ],
            ]
        ]
    ],
];

return $data;
