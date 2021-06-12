<?php

namespace Architecture\Infrastructure\Shared\Core\Domain;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * Class DomainEventAggregate
 *
 * Aggregate events for domain entity
 * @package Architecture\Infrastructure\Shared\Core\Domain
 */
abstract class DomainEventAggregate implements DomainEventAggregateInterface
{
    /**
     * @Ignore()
     * @var array
     */
    private $uncommittedEvents = [];

    /**
     * Applies an event. The event is added to the AggregateRoot's list of uncommitted events.
     *
     * @param mixed $event
     */
    public function apply($event): void
    {
        $this->handleRecursively($event);
        $this->uncommittedEvents[] = DomainMessage::recordNow($event);
    }

    /**
     * @param mixed $event
     */
    protected function handleRecursively($event): void
    {
        $this->handle($event);

        foreach ($this->getChildEntities() as $entity) {
            $entity->handleRecursively($event);
        }
    }

    /**
     * Handles event if capable.
     *
     * @param mixed $event
     */
    protected function handle($event): void
    {
        $method = $this->getApplyMethod($event);

        if (!method_exists($this, $method)) {
            return;
        }

        $this->$method($event);
    }

    /**
     * @Ignore
     * @param mixed $event
     *
     * @return string
     */
    private function getApplyMethod($event): string
    {
        $classParts = explode('\\', get_class($event));

        return 'apply' . end($classParts);
    }

    /**
     * Returns all child entities.
     *
     * Override this method if your aggregate root contains child entities.
     *
     * @Ignore
     * @return DomainEventEntity[]
     */
    protected function getChildEntities(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getUncommittedEvents(): DomainEventStream
    {
        $stream = new DomainEventStream($this->uncommittedEvents);
        $this->uncommittedEvents = [];
        return $stream;
    }
}
