<?php
declare(strict_types=1);


namespace Architecture\Infrastructure\User\ArgumentResolver;


use Architecture\Application\UseCases\Command\User\AddUser\CreateUserCommand;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Class AddUserArgumentResolver
 * @package Architecture\Infrastructure\User\ArgumentResolver
 */
class AddUserArgumentResolver implements ArgumentValueResolverInterface
{
    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === CreateUserCommand::class;
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return Generator|iterable
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $content = json_decode($request->getContent(), true);
        $userFirstName = (string)$content['userFirstName'] ?? '';
        $userLastName = (string)$content['userLastName'] ?? '';
        $userEmail = (string)$content['userEmail'] ?? '';
        $phone = (string)$content['phone'] ?? '';
        yield new CreateUserCommand($userFirstName, $userLastName, $userEmail, $phone);
    }
}