<?php

namespace Architecture\Infrastructure\Shared\Exception;

use Exception;

/**
 * Class NotImplementedException
 *
 * @package App\Infrastructure\Shared\Exception
 */
class NotImplementedException extends Exception
{
    /**
     * NotImplementedException constructor.
     *
     * @param string $featureName
     * @param int $code
     */
    public function __construct(string $featureName, int $code = 0)
    {
        if ($featureName) {
            $message = "Функционал '{$featureName}' не реализован";
        } else {
            $message = "Функционал не реализован";
        }

        parent::__construct($message, $code);
    }
}