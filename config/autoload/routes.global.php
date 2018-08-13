<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

return [
    'dependencies' => [
        'factories' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouterFactory::class,
        ],
    ],
    'router'       => [
        'fastroute' => [
            'cache_enabled' => true,
            'cache_file'    => 'data/cache/fastroute.cache.php',
        ],
    ],
];
