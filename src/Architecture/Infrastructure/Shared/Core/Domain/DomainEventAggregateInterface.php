<?php

namespace Architecture\Infrastructure\Shared\Core\Domain;

/**
 * Interface AggregateRoot
 *
 * @package Architecture\Infrastructure\Shared\Domain
 */
interface DomainEventAggregateInterface
{
    public function getUncommittedEvents(): DomainEventStream;
}
