<?php

namespace Architecture\UI\Http\Rest\Controller;


use Architecture\Application\UseCases\Command\CommandBusInterface;
use Architecture\Application\UseCases\Command\CommandInterface;
use Architecture\Application\UseCases\Query\QueryBusInterface;
use Architecture\Infrastructure\Shared\Exception\ValidationException;
use Architecture\Infrastructure\Shared\Validator\Formatter\ViolationsFormatterInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class CommandQueryController extends QueryController
{
    /**
     * @var CommandBusInterface
     */
    private CommandBusInterface $commandBus;

    /**
     * @var QueryBusInterface
     */
    private QueryBusInterface $queryBus;
    /**
     * @var LoggerInterface
     */
    public LoggerInterface $appLogger;


    /**
     * CommandQueryController constructor.
     *
     * @param CommandBusInterface $commandBus
     * @param QueryBusInterface $queryBus
     * @param ValidatorInterface $validator
     * @param ViolationsFormatterInterface $violationsFormatter
     * @param SerializerInterface $serializer
     * @param LoggerInterface $appLogger
     */
    public function __construct(
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        ValidatorInterface $validator,
        ViolationsFormatterInterface $violationsFormatter,
        SerializerInterface $serializer,
        LoggerInterface $appLogger
    )
    {
        parent::__construct($queryBus, $validator, $violationsFormatter, $serializer);
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->violationsFormatter = $violationsFormatter;
        $this->queryBus = $queryBus;
        $this->appLogger = $appLogger;
    }

    /**
     * @param CommandInterface $command
     *
     * @return mixed
     */
    protected function handle(CommandInterface $command)
    {
        return $this->commandBus->handle($command);
    }

    /**
     * @param ConstraintViolationListInterface $violationList
     *
     * @return JsonResponse
     */
    protected function validationErrorResponse(ConstraintViolationListInterface $violationList): JsonResponse
    {
        return $this->json(
            json_decode($this->violationsFormatter->formatViolations($violationList), true),
            JsonResponse::HTTP_BAD_REQUEST
        );
    }

    /**
     * @param mixed $value
     */
    public function validate($value): void
    {
        if (count($violations = $this->validator->validate($value))) {
            throw new ValidationException($this->violationsFormatter->formatViolations($violations));
        }
    }
}
