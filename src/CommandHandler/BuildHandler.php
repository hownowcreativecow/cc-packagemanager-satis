<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

namespace App\CommandHandler;

use Psr\Http\Message\ServerRequestInterface;

class BuildHandler extends AbstractCommandHandler
{

    /**
     * @inheritdoc
     */
    protected function getConsoleInputArguments(ServerRequestInterface $request): array
    {
        return [
            'command'          => 'build',
            'file'             => $this->satisConfig['config_json'],
            'output-dir'       => $this->satisConfig['output_dir'],
            '--repository-url' => $request->getQueryParams()['repository'] ?? null,
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
