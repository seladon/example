<?php

namespace Architecture\Infrastructure\Shared\Bus\Query;

use Architecture\Application\UseCases\Query\QueryBusInterface;
use Architecture\Application\UseCases\Query\QueryInterface;
use Architecture\Infrastructure\Shared\Bus\MessageBusExceptionTrait;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

/**
 * Class MessengerQueryBus
 *
 * @package Architecture\Infrastructure\Shared\Bus\Query
 */
class MessengerQueryBus implements QueryBusInterface
{
    use MessageBusExceptionTrait;

    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @param QueryInterface $query
     *
     * @return mixed
     * @throws Throwable
     */
    public function ask(QueryInterface $query)
    {
        try {
            $envelope = $this->messageBus->dispatch($query);
            /** @var HandledStamp $stamp */
            $stamp = $envelope->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }
    }
}
