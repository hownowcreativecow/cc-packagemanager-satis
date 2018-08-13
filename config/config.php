<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

use Zend\ConfigAggregator\ArrayProvider;
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

$cacheConfig = ['config_cache_path' => 'data/cache/config-cache.php',];
$aggregator  = new ConfigAggregator([

    /**
     * Zend configuration providers
     */
    \Zend\HttpHandlerRunner\ConfigProvider::class,

    /**
     * Zend Expressive configuration providers
     */
    \Zend\Expressive\ConfigProvider::class,
    \Zend\Expressive\Helper\ConfigProvider::class,
    \Zend\Expressive\Router\ConfigProvider::class,
    \Zend\Expressive\Router\FastRouteRouter\ConfigProvider::class,
    \Zend\Expressive\Twig\ConfigProvider::class,

    /**
     * Add the config cache key
     */
    new ArrayProvider($cacheConfig),

    /**
     * Application configuration providers
     */
    \Cc\OutputStream\ConfigProvider::class,
    \Cc\ConsoleOutput\ConfigProvider::class,
    new PhpFileProvider(realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php'),

], $cacheConfig['config_cache_path']);

return $aggregator->getMergedConfig();
