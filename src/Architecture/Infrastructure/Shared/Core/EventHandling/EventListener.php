<?php

namespace Architecture\Infrastructure\Shared\Core\EventHandling;

use Architecture\Infrastructure\Shared\Core\Domain\DomainMessage;

/**
 * Interface EventListener
 *
 * @package Architecture\Infrastructure\Shared\EventHandling
 */
interface EventListener
{
    /**
     * @param DomainMessage $domainMessage
     */
    public function handle(DomainMessage $domainMessage): void;
}
