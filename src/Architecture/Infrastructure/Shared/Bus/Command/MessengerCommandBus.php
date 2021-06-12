<?php

namespace Architecture\Infrastructure\Shared\Bus\Command;

use Architecture\Application\UseCases\Command\CommandBusInterface;
use Architecture\Application\UseCases\Command\CommandInterface;
use Architecture\Infrastructure\Shared\Bus\MessageBusExceptionTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\InvalidArgumentException;
use Symfony\Component\Messenger\Exception\RecoverableMessageHandlingException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

/**
 * Class MessengerCommandBus
 * Symfony Messenger implementation of CommandBusInterface
 */
class MessengerCommandBus implements CommandBusInterface
{
    use MessageBusExceptionTrait;

    /**
     * @var MessageBusInterface
     */
    private $messageBus;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    /**
     * @var LoggerInterface
     */
    private $appLogger;

    /**
     * MessengerCommandBus constructor.
     *
     * @param MessageBusInterface $messageBus
     * @param LoggerInterface $appLogger
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        MessageBusInterface $messageBus,
        LoggerInterface $appLogger,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->messageBus = $messageBus;
        $this->eventDispatcher = $eventDispatcher;
        $this->appLogger = $appLogger;
    }

    /**
     * @param CommandInterface $command
     *
     * @return mixed
     */
    public function handle(CommandInterface $command)
    {
        try {
            $envelope = $this->messageBus->dispatch($command);
            /** @var HandledStamp $stamp */
            $stamp = $envelope->last(HandledStamp::class);
            if ($stamp) {
                return $stamp->getResult();
            }
        } catch (HandlerFailedException $e) {

        }
    }
}
