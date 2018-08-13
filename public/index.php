<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

$rootDir = dirname(__DIR__);
chdir($rootDir);
require $rootDir . '/vendor/autoload.php';

(function () use ($rootDir) {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = require $rootDir . '/config/container.php';

    /** @var \Zend\Expressive\Application $app */
    $app     = $container->get(\Zend\Expressive\Application::class);
    $factory = $container->get(\Zend\Expressive\MiddlewareFactory::class);

    (require $rootDir . '/config/pipeline.php')($app, $factory, $container);
    (require $rootDir . '/config/routes.php')($app, $factory, $container);

    $app->run();
})();
