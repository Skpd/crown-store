<?php

namespace Catalog;

return [
    'router' => [
        'routes' => [
            'manage'   => [
                'type'         => 'literal',
                'may_terminal' => false,
                'options'      => [
                    'route' => '/manage',
                ],
                'child_routes' => [
                    'categories' => [
                        'type'         => 'literal',
                        'may_terminal' => false,
                        'options'      => [
                            'route'    => '/categories',
                            'defaults' => [
                                'controller' => 'Catalog\Controller\ManageCategories'
                            ]
                        ],
                        'child_routes' => [
                            'list'   => [
                                'type'    => 'literal',
                                'options' => [
                                    'route'    => '/list',
                                    'defaults' => [
                                        'action' => 'list'
                                    ]
                                ],
                            ],
                            'create' => [
                                'type'    => 'literal',
                                'options' => [
                                    'route'    => '/create',
                                    'defaults' => [
                                        'action' => 'create'
                                    ]
                                ],
                            ],
                            'update' => [
                                'type'    => 'segment',
                                'options' => [
                                    'route'    => '/update/:id',
                                    'defaults' => [
                                        'action' => 'update'
                                    ]
                                ],
                            ],
                            'delete' => [
                                'type'    => 'segment',
                                'options' => [
                                    'route'    => '/delete/:id',
                                    'defaults' => [
                                        'action' => 'delete'
                                    ]
                                ],
                            ],
                        ]
                    ],
                    'products'   => [
                        'type'         => 'literal',
                        'may_terminal' => false,
                        'options'      => [
                            'route'    => '/products',
                            'defaults' => [
                                'controller' => 'Catalog\Controller\ManageProducts'
                            ]
                        ],
                        'child_routes' => [
                            'list'   => [
                                'type'    => 'literal',
                                'options' => [
                                    'route'    => '/list',
                                    'defaults' => [
                                        'action' => 'list'
                                    ]
                                ],
                            ],
                            'create' => [
                                'type'    => 'literal',
                                'options' => [
                                    'route'    => '/create',
                                    'defaults' => [
                                        'action' => 'create'
                                    ]
                                ],
                            ],
                            'update' => [
                                'type'    => 'segment',
                                'options' => [
                                    'route'    => '/update/:id',
                                    'defaults' => [
                                        'action' => 'update'
                                    ]
                                ],
                            ],
                            'delete' => [
                                'type'    => 'segment',
                                'options' => [
                                    'route'    => '/delete/:id',
                                    'defaults' => [
                                        'action' => 'delete'
                                    ]
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'products' => [
                'type'          => 'literal',
                'may_terminate' => false,
                'options'       => [
                    'route'      => '/products',
                    'defaults' => [
                        'controller' => 'Catalog\Controller\Products',
                    ],
                ],
                'child_routes'  => [
                    'view' => [
                        'type'    => 'segment',
                        'options' => [
                            'route'  => '/:slug/:name',
                            'defaults' => [
                                'action' => 'view'
                            ],
                        ]
                    ],
                    'list-by-category' => [
                        'type'          => 'segment',
                        'may_terminate' => true,
                        'options'       => [
                            'route'  => '/:slug[/page/:page]',
                            'defaults' => [
                                'action' => 'list-by-category',
                                'page'   => 0
                            ],
                        ]
                    ],
                    'get-image' => [
                        'type' => 'segment',
                        'options' => [
                            'route'  => '/image/:id[/:type]',
                            'defaults' => [
                                'action' => 'get-image',
                                'type'   => 'medium'
                            ],
                        ]
                    ],
                ]
            ]
        ],
    ],
];