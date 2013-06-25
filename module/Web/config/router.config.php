<?php

namespace Web;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'          => 'literal',
                'options'       => [
                    'route'         => '/',
                    'defaults'      => [
                        'controller' => 'Web\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ]
        ]
    ]
];