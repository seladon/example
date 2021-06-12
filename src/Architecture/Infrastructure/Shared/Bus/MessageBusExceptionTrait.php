<?php

namespace Architecture\Infrastructure\Shared\Bus;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

/**
 * Trait MessageBusExceptionTrait
 */
trait MessageBusExceptionTrait
{
    /**
     * @param HandlerFailedException $exception
     *
     * @throws Throwable
     */
    public function throwException(HandlerFailedException $exception): void
    {
        while ($exception instanceof HandlerFailedException) {
            /** @var Throwable $exception */
            $exception = $exception->getPrevious();
        }

        throw $exception;
    }
}
