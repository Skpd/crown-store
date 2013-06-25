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
            'manufacture' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/manufacture',
                    'defaults' => [
                        'controller' => 'PhlySimplePage\Controller\Page',
                        'template'   => 'web/pages/manufacture',
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