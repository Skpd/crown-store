<?php

namespace Catalog;

return [
    'controllers'   => [
        'invokables' => [
            'Catalog\Controller\ManageCategories' => 'Catalog\Controller\ManageCategoriesController',
            'Catalog\Controller\ManageProducts'   => 'Catalog\Controller\ManageProductsController',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'CategoryForm' => 'Catalog\Form\CategoryForm',
            'ProductForm'  => 'Catalog\Form\ProductForm',
        ]
    ],
    'view_helpers'  => [
        'invokables' => [
            'CategoriesList' => 'Catalog\View\Helper\CategoriesList'
        ]
    ],
    'view_manager'  => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies'          => [
            'ViewJsonStrategy',
        ],
    ],
];