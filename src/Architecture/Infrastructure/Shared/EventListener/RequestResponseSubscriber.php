<?php

namespace Architecture\Infrastructure\Shared\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class RequestResponseSubscriber
 *
 * @package Architecture\UI\Http\Rest\EventSubscriber
 */
final class RequestResponseSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    protected $apiLogger;

    /**
     * RequestResponseSubscriber constructor.
     *
     * @param LoggerInterface $apiLogger
     */
    public function __construct(LoggerInterface $apiLogger)
    {
        $this->apiLogger = $apiLogger;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::REQUEST => 'logRequest',
            KernelEvents::RESPONSE => 'logResponse'
        );
    }

    /**
     * @param RequestEvent $event
     */
    public function logRequest(RequestEvent $event): void
    {
        $this->apiLogger->debug(
            "Api Request",
            [
                'url' => $event->getRequest()->getUri(),
                'params' => $event->getRequest()->query->all(),
                'body' => json_decode($event->getRequest()->getContent()),
            ]
        );
    }

    /**
     * @param ResponseEvent $event
     */
    public function logResponse(ResponseEvent $event): void
    {
        $this->apiLogger->debug(
            "Api Response",
            [
                'url' => $event->getRequest()->getUri(),
                'status' => $event->getResponse()->getStatusCode(),
                'response' => json_decode($event->getResponse()->getContent()),
            ]
        );
    }
}
