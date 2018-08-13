<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

return [
    'templates' => [
        'extension' => 'html.twig',
        'paths'     => [
            'app'    => ['templates/app',],
            'error'  => ['templates/error',],
            'layout' => ['templates/layout',],
            'satis'  => ['templates/satis',],
        ],
    ],
    'twig'      => [
        'cache_dir'       => 'data/cache/templates',
        'assets_url'      => '/assets/',
        'assets_version'  => '1.0.0',
        'extensions'      => [],
        'runtime_loaders' => [],
        'globals'         => [
            'lastUpdated' => null,
        ],
        'timezone'        => 'Europe/London',
        'optimizations'   => -1,
        'autoescape'      => 'html',
    ],
];
