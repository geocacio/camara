<?php

$data = [
    [
        'content' => 'service',
        'styles' => [
            'classes' => [
                '.container-service' => [
                    'name' => 'Caixa de Serviço',
                    'background_color' => '#e1e5e7',
                    'background_color_night' => '#1b1c1e',
                    'title_color' => '#303030',
                    'title_color_night' => '#ffffff',
                ],
                '.container-service:hover' => [
                    'name' => 'Efeito da caixa de Serviço',
                    'background_color' => '#3F45B6',
                    'background_color_night' => '#1d1f42',
                    'title_color' => '#ffffff',
                    'title_color_night' => '#ffffff',
                ],

                '.container-service .description .title' => [
                    'name' => 'Título',
                    'title_color' => '#303030',
                    'title_size' => '14',
                    'title_color_night' => '#ffffff',
                ],

                '.container-service:hover .description .title' => [
                    'name' => 'Título',
                    'title_color' => '#ffffff',
                    'title_color_night' => '#ffffff',
                ],

                '.container-service .description .text' => [
                    'name' => 'Texto',
                    'button_text_color' => '#303030',
                    'button_text_color_night' => '#e8eaed',
                    'button_text_size' => '12',
                ],

                '.container-service:hover .description .text' => [
                    'name' => 'Texto',
                    'title_color' => '#ffffff',
                    'title_color_night' => '#ffffff',
                ],

                '.container-service i' => [
                    'name' => 'Ícone',
                    'button_text_color' => '#303030',
                    'button_text_color_night' => '#c5c5c5',
                ],

                '.container-service:hover i' => [
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
                    'name' => 'Seção',
                    'background_color' => '#ffffff',
                    'background_color_night' => '#1b1c1e',
                ],
                '.posts-container .post .content .date' => [
                    'name' => 'Data',
                    'title_color' => '#212529',
                    'title_color_night' => '#dbdbdb',
                ],
                '.posts-container .post .content .title' => [
                    'name' => 'Título',
                    'title_color' => '#242768',
                    'title_color_night' => '#7276b9',
                ],
                '.posts-container .post .content .text' => [
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
                    'name' => 'Link',
                    'background_color' => '#30358c',
                    'background_color_night' => '#1b1c1e',
                ],
                '.main-style-list .item .link .title' => [
                    'name' => 'Título',
                    'title_color' => '#303030',
                    'title_color_night' => '#dbdbdb',
                    'title_size' => '14',
                ],
                '.main-style-list .item .link .description' => [
                    'name' => 'Descrição',
                    'title_color' => '#555555',
                    'title_color_night' => '#f7f7f7',
                    'title_size' => '13',
                ],

                '.main-style-list .item .link .additional-informations' => [
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
