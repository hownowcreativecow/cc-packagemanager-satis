<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

namespace App;

use Composer\Satis\Console\Application;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ApplicationFactory implements FactoryInterface
{

    /**
     * @inheritdoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Application
    {
        /** @var Application $application */
        $application = new $requestedName;
        $application->setAutoExit(false);

        return $application;
    }
}
