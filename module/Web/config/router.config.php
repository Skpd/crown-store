<?php

namespace Web;

return [
    'router' => [
        'routes' => [
            'home'        => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'Web\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ],
            'news' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/news',
                    'defaults' => [
                        'controller' => 'PhlySimplePage\Controller\Page',
                        'template'   => 'web/pages/news',
                    ],
                ],
            ],
            'production' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/production',
                    'defaults' => [
                        'controller' => 'PhlySimplePage\Controller\Page',
                        'template'   => 'web/pages/production',
                    ],
                ],
            ],
            'contacts' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/contacts',
                    'defaults' => [
                        'controller' => 'PhlySimplePage\Controller\Page',
                        'template'   => 'web/pages/contacts',
                    ],
                ],
            ],
        ]
    ]
];