<?php

declare(strict_types=1);


namespace Architecture\Infrastructure\Shared\Exception;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

/**
 * Class ValidationException
 *
 * @package App\Infrastructure\Shared\Exception
 */
class ValidationException extends HttpException
{
    /**
     * ValidationException constructor.
     *
     * @param string|null $message
     * @param Throwable|null $previous
     * @param array $headers
     * @param int|null $code
     */
    public function __construct(
        string $message = null,
        Throwable $previous = null,
        array $headers = [],
        ?int $code = 0
    ) {
        parent::__construct(JsonResponse::HTTP_BAD_REQUEST, $message, $previous, $headers, $code);
    }
}
