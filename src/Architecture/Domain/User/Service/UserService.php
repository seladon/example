<?php
declare(strict_types=1);

namespace Architecture\Domain\User\Service;


use Architecture\Infrastructure\Shared\Core\Domain\DomainEventPublisher;
use Architecture\Application\UseCases\Command\User\AddUser\CreateUserCommand;
use Architecture\Application\UseCases\Query\User\GetUser\GetUserQuery;
use Architecture\Domain\User\Repository\UserRepositoryInterface;
use Architecture\Domain\User\Entity\User;
use Architecture\Domain\User\ValueObject\Email;
use Architecture\Domain\User\ValueObject\Phone;
use OpenTracing\GlobalTracer;


/**
 * Class UserService
 *
 * @package Architecture\Domain\User\Service
 */
class UserService
{
    /**
     * @var UserRepositoryInterface $userRepository
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var DomainEventPublisher $domainEventPublisher
     */
    private DomainEventPublisher $domainEventPublisher;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     * @param DomainEventPublisher $domainEventPublisher
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        DomainEventPublisher $domainEventPublisher
    )
    {
        $this->userRepository = $userRepository;
        $this->domainEventPublisher = $domainEventPublisher;
    }

    /**
     * @param GetUserQuery $userQuery
     * @return User
     */
    public function getUserById(GetUserQuery $userQuery): User
    {
        return $this->userRepository->getUserById($userQuery->getUserId());
    }

    /**
     * @param CreateUserCommand $createUserCommand
     * @return int
     */
    public function addUser(CreateUserCommand $createUserCommand): int
    {
        $span = GlobalTracer::get()->startActiveSpan(__FUNCTION__);
        $span->getSpan();

        $user = User::create()
            ->setFirstName($createUserCommand->getUserFirstName())
            ->setLastName($createUserCommand->getUserLastName());
        $email = Email::create($createUserCommand->getUserEmail());
        $phone = Phone::create($createUserCommand->getPhone());
        $user->setPhone($phone)->setEmail($email);

        $result = $this->userRepository->persist($user);
        $user->setId($result);
        $user->wasAdd();
        $this->domainEventPublisher->publish($user);

        $span->close();
        return $result;
    }
}