<?php

use core\Utils;

return [
    'Paths' => [
        'LogDir' => Utils::normalizePath(__DIR__ . '/../assets/logs/'),
        'TempDir' => Utils::normalizePath(__DIR__ . '/../assets/temp/'),
        'ProductImagesDir' => Utils::normalizePath(__DIR__ . '/../assets/images/products/'),
        'ProductImagesDirRelative' => Utils::normalizePath('/assets/images/products/'),
    ],
    'Files' => [
        'SystemLog' => Utils::normalizePath(__DIR__ . '/../assets/logs/system.log'),
    ]
];
