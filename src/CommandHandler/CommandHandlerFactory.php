<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

namespace App\CommandHandler;

use Cc\OutputStream\SharedSocket;
use Composer\Satis\Console\Application;
use Interop\Container\ContainerInterface;
use SensioLabs\AnsiConverter\Theme\Theme;
use Symfony\Component\Console\Output\OutputInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CommandHandlerFactory implements FactoryInterface
{

    /**
     * @inheritdoc
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ): AbstractCommandHandler {
        return new $requestedName(
            $container->get(Application::class),
            $container->get(OutputInterface::class),
            $container->get(SharedSocket::class),
            $container->get(Theme::class),
            $container->get('config')['creativecow']['satis'] ?? []
        );
    }
}
