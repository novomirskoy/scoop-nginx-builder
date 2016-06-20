<?php

use Novomirskoy\ScoopNginxBuilder\Command;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'dependencies' => [
        'factories' => [
            Command\LatestVersion::class => Command\Factory\LatestVersionFactory::class,
            Command\Hash::class => InvokableFactory::class,
            Command\Generate::class => InvokableFactory::class,
        ],
    ],
    
    'console' => [
        'commands' => [
            Command\LatestVersion::class,
            Command\Hash::class,
            Command\Generate::class,
        ],
    ],

    'nginx-download-path' => 'http://nginx.org/download/',
    'upload-directory' => __DIR__ . '/../data/upload',
];
