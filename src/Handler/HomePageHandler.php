<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class HomePageHandler implements RequestHandlerInterface
{

    /**
     * @var TemplateRendererInterface
     */
    protected $template;

    /**
     * Constructor
     *
     * @param TemplateRendererInterface $template
     */
    public function __construct(TemplateRendererInterface $template)
    {
        $this->template = $template;
    }

    /**
     * @inheritdoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->template->render('app::home-page', [
            'packageList' => $this->getPackageList(),
        ]));
    }

    protected function getPackageList(): ?string
    {
        $cacheFile = realpath('data/cache/package-list.html');
        if (!$cacheFile || !file_exists($cacheFile)) {
            return null;
        }

        $this->template->addDefaultParam(TemplateRendererInterface::TEMPLATE_ALL, 'lastUpdated', filemtime($cacheFile));
        return file_get_contents($cacheFile);
    }
}
