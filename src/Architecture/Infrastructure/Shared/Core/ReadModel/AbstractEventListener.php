<?php

namespace Architecture\Infrastructure\Shared\Core\ReadModel;

use Architecture\Infrastructure\Shared\Core\Domain\DomainMessage;
use Architecture\Infrastructure\Shared\Core\EventHandling\EventListener;

abstract class AbstractEventListener implements EventListener
{
    /**
     * {@inheritdoc}
     */
    public function handle(DomainMessage $domainMessage): void
    {
        $event = $domainMessage->getPayload();
        $method = $this->getHandleMethod($event);
        if (!method_exists($this, $method)) {
            return;
        }

        $this->$method($event, $domainMessage);
    }

    /**
     * @param mixed $event
     *
     * @return string
     */
    private function getHandleMethod($event): string
    {
        $classParts = explode('\\', get_class($event));

        return 'apply' . end($classParts);
    }
}
