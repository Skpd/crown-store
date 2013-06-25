<?php

namespace Catalog;

return [
    'asset_manager' => [
        'resolver_configs' => [
            'paths' => [
                __NAMESPACE__ => __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public'
            ]
        ]
    ]
];
