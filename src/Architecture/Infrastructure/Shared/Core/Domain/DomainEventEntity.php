<?php

namespace Architecture\Infrastructure\Shared\Core\Domain;

/**
 * Interface DomainEventEntity
 *
 * @package Architecture\Infrastructure\Shared\Core\Domain
 */
interface DomainEventEntity
{
    /**
     * Recursively handles $event.
     *
     * @param mixed $event
     */
    public function handleRecursively($event): void;
}
