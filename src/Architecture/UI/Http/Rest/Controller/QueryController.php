<?php

declare(strict_types=1);

namespace Architecture\UI\Http\Rest\Controller;

use Architecture\Application\UseCases\Query\QueryBusInterface;
use Architecture\Application\UseCases\Query\QueryInterface;
use Architecture\Infrastructure\Shared\Validator\Formatter\ViolationsFormatterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class QueryController
 *
 * @package Architecture\UI\Http\Rest\Controller
 */
abstract class QueryController extends AbstractController
{
    /**
     * @var QueryBusInterface
     */
    private QueryBusInterface $queryBus;

    /**
     * @var ValidatorInterface
     */
    protected ValidatorInterface $validator;

    /**
     * @var ViolationsFormatterInterface
     */
    protected ViolationsFormatterInterface $violationsFormatter;

    /**
     * @var SerializerInterface
     */
    protected SerializerInterface $serializer;

    /**
     * QueryController constructor.
     *
     * @param QueryBusInterface $queryBus
     * @param ValidatorInterface $validator
     * @param ViolationsFormatterInterface $violationsFormatter
     * @param SerializerInterface $serializer
     */
    public function __construct(
        QueryBusInterface $queryBus,
        ValidatorInterface $validator,
        ViolationsFormatterInterface $violationsFormatter,
        SerializerInterface $serializer
    ) {
        $this->queryBus = $queryBus;
        $this->validator = $validator;
        $this->violationsFormatter = $violationsFormatter;
        $this->serializer = $serializer;
    }

    /**
     * @param QueryInterface $query
     *
     * @return mixed
     *
     */
    protected function ask(QueryInterface $query)
    {
        return $this->queryBus->ask($query);
    }
}
