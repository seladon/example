<?php

namespace Architecture\Infrastructure\Shared\Core\Domain;

use ArrayIterator;
use IteratorAggregate;

/**
 * Class DomainEventStream
 *
 * @package Architecture\Infrastructure\Shared\Core\Domain
 */
class DomainEventStream implements IteratorAggregate
{
    private $events;

    /**
     * @param mixed[] $events
     */
    public function __construct(array $events)
    {
        $this->events = $events;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->events);
    }
}
