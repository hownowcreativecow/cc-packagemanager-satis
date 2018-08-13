<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

namespace App\CommandHandler;

use Cc\ConsoleOutput\StreamedOutput;
use Cc\OutputStream\OutputStream;
use Cc\OutputStream\SharedSocket;
use Composer\Satis\Console\Application;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SensioLabs\AnsiConverter\Theme\Theme;
use Symfony\Component\Console\Input\ArrayInput;
use Zend\Diactoros\Response\HtmlResponse;

abstract class AbstractCommandHandler implements RequestHandlerInterface
{

    /**
     * @var Application
     */
    protected $consoleApplication;

    /**
     * @var StreamedOutput
     */
    protected $consoleOutput;

    /**
     * @var array
     */
    protected $streamSocketPair;

    /**
     * @var Theme
     */
    protected $converterTheme;

    /**
     * @var array
     */
    protected $satisConfig;

    /**
     * Constructor
     *
     * @param Application    $consoleApplication
     * @param StreamedOutput $consoleOutput
     * @param array          $streamSocketPair
     * @param Theme          $converterTheme
     * @param array          $satisConfig
     */
    public function __construct(
        Application $consoleApplication,
        StreamedOutput $consoleOutput,
        array $streamSocketPair,
        Theme $converterTheme,
        array $satisConfig
    ) {
        $this->consoleApplication = $consoleApplication;
        $this->consoleOutput      = $consoleOutput;
        $this->streamSocketPair   = $streamSocketPair;
        $this->converterTheme     = $converterTheme;
        $this->satisConfig        = $satisConfig;
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Create input to trigger command
        $input = new ArrayInput($this->getConsoleInputArguments($request));

        // Return response
        return new HtmlResponse(new OutputStream(
            $this->streamSocketPair[SharedSocket::PARENT],
            function () use ($input) {
                $this->outputHeader();
                $this->triggerPreCallback();
                $this->consoleApplication->run($input, $this->consoleOutput);
                $this->triggerPostCallback();
                $this->outputFooter();
            }
        ), 200, [
            'Cache-Control' => 'no-cache',
        ]);
    }

    /**
     * Get the input arguments for the console application
     *
     * @param ServerRequestInterface $request
     *
     * @return array
     */
    abstract protected function getConsoleInputArguments(ServerRequestInterface $request): array;

    /**
     * Trigger callback for before the console application is run
     *
     * @return void
     */
    protected function triggerPreCallback(): void
    {
    }

    /**
     * Trigger callback for after the console application is run
     *
     * @return void
     */
    protected function triggerPostCallback(): void
    {
    }

    /**
     * Output header
     *
     * @return void
     */
    protected function outputHeader(): void
    {
        fwrite($this->streamSocketPair[SharedSocket::CHILD], <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<style type="text/css">
    {$this->converterTheme->asCss()}
    body {padding:0;margin:0;}
    .ansi_box {padding:10px 15px;font-family: monospace}
</style>
</head>
<body>
<div class="ansi_color_bg_black ansi_color_fg_white ansi_box">
HTML
        );
    }

    /**
     * Output footer
     *
     * @return void
     */
    protected function outputFooter(): void
    {
        fwrite($this->streamSocketPair[SharedSocket::CHILD], <<<HTML
</div>
</body>
</html>
HTML
        );
    }
}
