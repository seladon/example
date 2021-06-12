<?php
declare(strict_types=1);

namespace Architecture\Application\UseCases\Query\User\GetUser;


use Architecture\Application\UseCases\Query\QueryHandlerInterface;
use Architecture\Domain\User\Entity\User;
use Architecture\Domain\User\Service\UserService;

/**
 * Class GetUserHandler
 *
 * @package Architecture\Application\UseCases\Query\User\GetUser
 */
class GetUserHandler implements QueryHandlerInterface
{

    private UserService $userService;

    /**
     * ChangeLoginHandler constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param GetUserQuery $command
     * @return User
     */
    public function __invoke(GetUserQuery $command) : User
    {
        return $this->userService->getUserById($command);
    }
}