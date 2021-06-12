<?php

declare(strict_types=1);

namespace Architecture\Infrastructure\Shared\EventListener;

use Architecture\Infrastructure\Shared\Exception\NotFoundException;
use Architecture\Infrastructure\Shared\Exception\ValidationException;
use ArrayObject;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use UnexpectedValueException;

class ExceptionFormatterSubscriber extends ApiEventSubscriber
{
    public const PROD_ENV = 'prod';

    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $params;

    /**
     * ExceptionFormatterSubscriber constructor.
     *
     * @param ParameterBagInterface $params
     */
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException'
        ];
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = new ArrayObject();
        $response->setFlags(ArrayObject::ARRAY_AS_PROPS);
        switch (true) {
            case $exception instanceof BadRequestHttpException:
                $httpCode = Response::HTTP_BAD_REQUEST;
                $response->applicationErrorCode = 'BAD_REQUEST';
                $response->message = $exception->getMessage();
                break;
            case $exception instanceof NotFoundException:
            case $exception instanceof NotFoundHttpException:
                $httpCode = Response::HTTP_NOT_FOUND;
                $response->applicationErrorCode = 'NOT_FOUND';
                $response->message = $exception->getMessage() ?: 'Ресурс не найден.';
                break;
            case $exception instanceof MethodNotAllowedHttpException:
                $httpCode = Response::HTTP_METHOD_NOT_ALLOWED;
                $response->applicationErrorCode = 'NOT_ALLOWED';
                $response->message = $exception->getMessage() ?: 'Метод не доступен';
                break;
            case $exception instanceof UnauthorizedHttpException:
                $httpCode = Response::HTTP_UNAUTHORIZED;
                $response->applicationErrorCode = 'UNAUTHORIZED';
                $response->message = $exception->getMessage() ?: 'Ошибка аутентификации';
                break;
            case $exception instanceof AccessDeniedHttpException:
                $httpCode = Response::HTTP_FORBIDDEN;
                $response->applicationErrorCode = 'FORBIDDEN';
                $response->message = 'Недостаточно прав для выполнения запроса';
                break;
            case $exception instanceof ExtraAttributesException:
                $httpCode = JsonResponse::HTTP_BAD_REQUEST;
                $response->applicationErrorCode = 'VALIDATION_ERROR';
                $response->message = 'Переданы неверные параметры в запросе: ' . json_encode(
                        $exception->getExtraAttributes()
                    );
                break;
            case $exception instanceof NotEncodableValueException:
                $httpCode = JsonResponse::HTTP_BAD_REQUEST;
                $response->applicationErrorCode = $exception->getCode() ?: 'BAD_REQUEST';
                $response->message = $exception->getMessage() ?: 'Произошла ошибка, повторите позднее';
                break;
            case $exception instanceof ValidationException:
            case $exception instanceof UnexpectedValueException:
                $httpCode = JsonResponse::HTTP_BAD_REQUEST;
                $response->applicationErrorCode = $exception->getCode() ?: 'VALIDATION_ERROR';
                $response->message = $exception->getMessage() ?: 'Произошла ошибка валидации, повторите позднее';
                break;
            default:
                $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                $response->applicationErrorCode = 'INTERNAL_SERVER_ERROR';
                $response->message = $exception->getMessage() ?: 'Возникла ошибка на сервере';
                break;
        }

        if ($this->params->get('kernel.environment') !== self::PROD_ENV) {
            $response->debug = $exception->getTraceAsString();
        }
        $event->setResponse(new JsonResponse((array)$response, $httpCode));
    }
}