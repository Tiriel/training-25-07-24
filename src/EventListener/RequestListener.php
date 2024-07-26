<?php

namespace App\EventListener;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Twig\Environment;

final class RequestListener
{
    public function __construct(
        protected readonly Environment $twig,
        #[Autowire(param: 'env(bool:APP_MAINTENANCE)')]
        protected readonly bool $isMaintenance,
    )
    {
    }

    #[AsEventListener(event: RequestEvent::class, priority: 9999)]
    public function onKernelRequest(RequestEvent $event): void
    {
        if ($this->isMaintenance) {
            $response = new Response();

            if ($event->isMainRequest()) {
                $response->setContent($this->twig->render('maintenance.html.twig'));
            }

            $event->setResponse($response);
        }
    }
}
