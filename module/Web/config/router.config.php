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
            'calc' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/calc',
                    'defaults' => [
                        'controller' => 'PhlySimplePage\Controller\Page',
                        'template'   => 'web/pages/calc',
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