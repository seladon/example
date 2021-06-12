<?php

declare(strict_types=1);

namespace Architecture\Infrastructure\Shared\Exception;

use Exception;

class NotFoundException extends Exception
{
    public function __construct(string $message = 'Resource not found')
    {
        parent::__construct($message);
    }
}
