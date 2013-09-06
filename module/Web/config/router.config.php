<?php

namespace Web;

return [
    'router' => [
        'routes' => [
            'home'      => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'Web\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ],
            'calc'      => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/calc',
                    'defaults' => [
                        'controller' => 'PhlySimplePage\Controller\Page',
                        'template'   => 'web/pages/calc',
                    ],
                ],
            ],
            'warehouse' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/warehouse',
                    'defaults' => [
                        'controller' => 'PhlySimplePage\Controller\Page',
                        'template'   => 'web/pages/warehouse',
                    ],
                ],
            ],
            'contacts'  => [
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