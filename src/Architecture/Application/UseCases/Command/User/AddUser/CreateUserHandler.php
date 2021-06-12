<?php
declare(strict_types=1);

namespace Architecture\Application\UseCases\Command\User\AddUser;


use Architecture\Application\UseCases\Command\CommandHandlerInterface;
use Architecture\Domain\User\Service\UserService;


/**
 * Class CreateUserHandler
 *
 * @package Architecture\Application\UseCases\Command\User\AddUser
 */
class CreateUserHandler implements CommandHandlerInterface
{

    private UserService $createUserService;

    /**
     * CreateUserHandler constructor.
     *
     * @param UserService $createUserService
     */
    public function __construct(UserService $createUserService)
    {
        $this->createUserService = $createUserService;
    }

    /**
     * @param CreateUserCommand $command
     * @return int
     */
    public function __invoke(CreateUserCommand $command): int
    {
        return $this->createUserService->addUser($command);
    }
}