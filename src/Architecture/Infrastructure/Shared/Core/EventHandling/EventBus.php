<?php

namespace Architecture\Infrastructure\Shared\Core\EventHandling;

use Architecture\Infrastructure\Shared\Core\Domain\DomainEventStream;

interface EventBus
{
    /**
     * Subscribes the event listener to the event bus.
     *
     * @param EventListener $eventListener
     */
    public function subscribe(EventListener $eventListener): void;

    /**
     * Publishes the events from the domain event stream to the listeners.
     *
     * @param DomainEventStream $domainMessages
     */
    public function publish(DomainEventStream $domainMessages): void;
}
