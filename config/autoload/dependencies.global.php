<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

return [
    'dependencies' => [
        'factories' => [
            \Composer\Satis\Console\Application::class => \App\ApplicationFactory::class,
            \App\CommandHandler\AddHandler::class      => \App\CommandHandler\CommandHandlerFactory::class,
            \App\CommandHandler\BuildHandler::class    => \App\CommandHandler\CommandHandlerFactory::class,
            \App\CommandHandler\PurgeHandler::class    => \App\CommandHandler\CommandHandlerFactory::class,
            \App\Handler\HomePageHandler::class        => \App\Handler\HomePageHandlerFactory::class,
        ],
    ],
];
