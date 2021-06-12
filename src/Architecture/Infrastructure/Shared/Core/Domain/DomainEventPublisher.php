<?php

namespace Architecture\Infrastructure\Shared\Core\Domain;

use Architecture\Infrastructure\Shared\Core\EventHandling\EventBus;

/**
 * Class DomainEventPublisher
 * Publish aggregated events to event bus
 *
 * @package Architecture\Infrastructure\Shared\Domain
 */
class DomainEventPublisher
{
    private EventBus $eventBus;

    /**
     * @param EventBus $eventBus
     */
    public function __construct(EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * @param DomainEventAggregateInterface $aggregate
     *
     */
    public function publish(DomainEventAggregateInterface $aggregate): void
    {
        $domainEventStream = $aggregate->getUncommittedEvents();
        $this->eventBus->publish($domainEventStream);
    }
}
