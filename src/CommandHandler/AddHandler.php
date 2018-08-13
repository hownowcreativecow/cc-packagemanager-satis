<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

namespace App\CommandHandler;

use Psr\Http\Message\ServerRequestInterface;

class AddHandler extends AbstractCommandHandler
{

    /**
     * @inheritdoc
     */
    protected function getConsoleInputArguments(ServerRequestInterface $request): array
    {
        return [
            'command' => 'add',
            'file'    => $this->satisConfig['config_json'],
            'url'     => $request->getQueryParams()['repository'],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function triggerPostCallback(): void
    {
        $oldFile = $this->satisConfig['output_dir'] . '/index.html';
        if (file_exists($oldFile)) {
            rename($oldFile, realpath('data/cache') . '/package-list.html');
        }
    }
}
