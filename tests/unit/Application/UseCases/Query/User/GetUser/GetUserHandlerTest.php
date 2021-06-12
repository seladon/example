<?php
declare(strict_types=1);

namespace Tests\unit\Application\UseCases\Query\User\GetUser;


use Architecture\Application\UseCases\Command\User\AddUser\CreateUserCommand;
use Architecture\Application\UseCases\Command\User\AddUser\CreateUserHandler;
use Architecture\Application\UseCases\Query\User\GetUser\GetUserHandler;
use Architecture\Application\UseCases\Query\User\GetUser\GetUserQuery;
use Architecture\Domain\User\Entity\User;
use Architecture\Domain\User\Repository\UserRepositoryInterface;
use Architecture\Domain\User\Service\UserService;
use Architecture\Infrastructure\Shared\Core\Domain\DomainEventPublisher;
use Codeception\PHPUnit\TestCase;
use Tests\unit\Domain\User\Doubles\InMemoryRepository;

/**
 * Class GetUserHandlerTest
 *
 * @package Tests\unit\Application\UseCases\Query\User\GetUser
 */
class GetUserHandlerTest extends TestCase
{
    protected UserRepositoryInterface $repository;
    protected UserService $service;
    protected DomainEventPublisher $domainEventPublisher;

    public function setUp(): void
    {
        $this->domainEventPublisher = $this->createMock(DomainEventPublisher::class);
        $this->repository = new InMemoryRepository();
        $this->service = new UserService($this->repository, $this->domainEventPublisher);
    }

    public function testCommandCanBeGet()
    {
        $handler = new CreateUserHandler($this->service);
        $userFirstName = "sergey";
        $userLastName = "rudnev";
        $userEmail = "joe@example.com";
        $userPhone = "+79261167248";
        $command = new CreateUserCommand($userFirstName, $userLastName, $userEmail, $userPhone);
        $userId = $handler($command);

        $handler = new GetUserHandler($this->service);
        $query = new GetUserQuery($userId);
        $user = $handler($query);
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame($userId, $user->getId());
    }

    public function tearDown(): void
    {
        unset($this->repository);
        unset($this->service);
    }
}