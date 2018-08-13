<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

/**
 * Setup routes with a single request method:
 *
 * @param Application        $app
 * @param MiddlewareFactory  $factory
 * @param ContainerInterface $container
 *
 * @return void
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/', \App\Handler\HomePageHandler::class, 'home');
    $app->get('/add', \App\CommandHandler\AddHandler::class, 'add');
    $app->get('/build', \App\CommandHandler\BuildHandler::class, 'build');
    $app->get('/purge', \App\CommandHandler\PurgeHandler::class, 'purge');
};
