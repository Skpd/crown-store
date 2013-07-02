<?php

namespace Catalog;

return [
    'service_manager' => [
        'aliases' => [
            'orm_manager' => 'Doctrine\ORM\EntityManager'
        ]
    ],
    'controllers'     => [
        'invokables' => [
            'Catalog\Controller\ManageCategories' => 'Catalog\Controller\ManageCategoriesController',
            'Catalog\Controller\ManageProducts'   => 'Catalog\Controller\ManageProductsController',
            'Catalog\Controller\Products'         => 'Catalog\Controller\ProductsController',
        ],
    ],
    'form_elements'   => [
        'invokables' => [
            'CategoryForm' => 'Catalog\Form\CategoryForm',
            'ProductForm'  => 'Catalog\Form\ProductForm',
        ]
    ],
    'view_helpers'    => [
        'invokables' => [
            'CategoriesList' => 'Catalog\View\Helper\CategoriesList'
        ]
    ],
    'view_manager'    => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'template_map'        => [
            'catalog/categories' => __DIR__ . '/../view/catalog/categories/default-list.phtml',
        ],
        'strategies'          => [
            'ViewJsonStrategy',
        ],
    ],
];