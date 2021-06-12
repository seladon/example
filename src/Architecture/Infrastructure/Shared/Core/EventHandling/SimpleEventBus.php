<?php

namespace Architecture\Infrastructure\Shared\Core\EventHandling;

use Architecture\Infrastructure\Shared\Core\Domain\DomainEventStream;

class SimpleEventBus implements EventBus
{
    private array $eventListeners = [];
    private array $queue = [];
    private bool $isPublishing = false;

    /**
     * Subscribes the event listener to the event bus.
     *
     * @param EventListener $eventListener
     */
    public function subscribe(EventListener $eventListener): void
    {
        $this->eventListeners[] = $eventListener;
    }

    /**
     * Publishes the events from the domain event stream to the listeners.
     *
     * @param DomainEventStream $domainMessages
     */
    public function publish(DomainEventStream $domainMessages): void
    {
        foreach ($domainMessages as $domainMessage) {
            $this->queue[] = $domainMessage;
        }

        if (!$this->isPublishing) {
            $this->isPublishing = true;

            try {

                while ($domainMessage = array_shift($this->queue)) {
                    foreach ($this->eventListeners as $eventListener) {
                        $eventListener->handle($domainMessage);
                    }
                }
            } finally {
                $this->isPublishing = false;
            }
        }
    }
}
