<?php
declare(strict_types=1);


namespace Architecture\Infrastructure\User\ArgumentResolver;


use Architecture\Application\UseCases\Query\User\GetUser\GetUserQuery;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Class GetUserArgumentResolver
 * @package Architecture\Infrastructure\User\ArgumentResolver
 */
class GetUserArgumentResolver implements ArgumentValueResolverInterface
{

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === GetUserQuery::class;
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return Generator|iterable
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $userId = (int)$request->get('userId') ?? '';
        yield new GetUserQuery($userId);
    }
}