<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

namespace App\CommandHandler;

use Psr\Http\Message\ServerRequestInterface;

class PurgeHandler extends AbstractCommandHandler
{

    /**
     * @inheritdoc
     */
    protected function getConsoleInputArguments(ServerRequestInterface $request): array
    {
        return [
            'command'    => 'purge',
            'file'       => $this->satisConfig['config_json'],
            'output-dir' => $this->satisConfig['output_dir'],
        ];
    }
}
