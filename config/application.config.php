<?php

return [
    'modules'                 => [
//        'ZendDeveloperTools',
        'AssetManager',
        'DoctrineModule',
        'DoctrineORMModule',
        'PhlySimplePage',
        'Catalog',
        'Web',
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php',
        ],
        'module_paths'      => [
            './module',
            './vendor',
        ],
    ],
];