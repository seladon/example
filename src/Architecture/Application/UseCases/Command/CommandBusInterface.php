<?php

declare(strict_types=1);

namespace Architecture\Application\UseCases\Command;

interface CommandBusInterface
{
    public function handle(CommandInterface $command);
}
