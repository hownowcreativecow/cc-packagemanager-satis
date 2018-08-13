<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\Handler\NotFoundHandler;
use Zend\Expressive\Helper\ServerUrlMiddleware;
use Zend\Expressive\Helper\UrlHelperMiddleware;
use Zend\Expressive\MiddlewareFactory;
use Zend\Expressive\Router\Middleware\DispatchMiddleware;
use Zend\Expressive\Router\Middleware\ImplicitHeadMiddleware;
use Zend\Expressive\Router\Middleware\ImplicitOptionsMiddleware;
use Zend\Expressive\Router\Middleware\MethodNotAllowedMiddleware;
use Zend\Expressive\Router\Middleware\RouteMiddleware;
use Zend\Stratigility\Middleware\ErrorHandler;

/**
 * Setup middleware pipeline:
 *
 * @param Application        $app
 * @param MiddlewareFactory  $factory
 * @param ContainerInterface $container
 *
 * @return void
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {

    /**
     * Application middleware
     */
    $app->pipe(ErrorHandler::class);
    $app->pipe(ServerUrlMiddleware::class);

    /**
     * Bootstrapping middleware
     */
    $app->pipe(RouteMiddleware::class);

    /**
     * Route failure handling middleware
     */
    $app->pipe(ImplicitHeadMiddleware::class);
    $app->pipe(ImplicitOptionsMiddleware::class);
    $app->pipe(MethodNotAllowedMiddleware::class);

    /**
     * Helper middleware
     */
    $app->pipe(UrlHelperMiddleware::class);

    /**
     * Dispatch middleware
     */
    $app->pipe(DispatchMiddleware::class);

    /**
     * Not found middleware
     */
    $app->pipe(NotFoundHandler::class);
};
