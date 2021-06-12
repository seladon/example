<?php
declare(strict_types=1);


namespace Tests\unit\Domain\User\Service;


use Architecture\Application\UseCases\Command\User\AddUser\CreateUserCommand;
use Architecture\Domain\User\Entity\User;
use Architecture\Domain\User\Exception\EmailInvalid;
use Architecture\Infrastructure\Shared\Core\Domain\DomainEventPublisher;
use Codeception\PHPUnit\TestCase;
use Architecture\Domain\User\Exception\CouldNotConfirmEmail;
use Architecture\Domain\User\Repository\UserRepositoryInterface;
use Architecture\Domain\User\Service\UserService;
use Tests\unit\Domain\User\Doubles\InMemoryRepository;

class UserServiceTest extends TestCase
{

    protected UserRepositoryInterface $repository;
    protected UserService $service;

    protected function setUp(): void
    {
        $stub = $this->createMock(DomainEventPublisher::class);
        $this->repository = new InMemoryRepository();
        $this->service = new UserService($this->repository, $stub);
    }

    public function testAddUser()
    {
        $userId = 1;
        $userFirstName = "sergey";
        $userLastName = "rudnev";
        $userEmail = "joe@example.com";
        $userPhone = "123456789";
        $command = new CreateUserCommand($userFirstName, $userLastName, $userEmail, $userPhone);
        $command->setUserId(1);
        $this->service->addUser($command);

        $this->assertInstanceOf(User::class, $this->repository->getUserById($userId));
        $this->assertSame($command->getUserId(), $this->repository->getUserById($userId)->getId());
    }

    public function testGetUser()
    {
        $userFirstName = "sergey";
        $userLastName = "rudnev";
        $userEmail = "joe@example.com";
        $userPhone = "123456789";
        $command = new CreateUserCommand($userFirstName, $userLastName, $userEmail, $userPhone);
        $this->service->addUser($command);
        $this->assertSame(null, $this->repository->getUserById(3));
    }

    public function testGetUserFail()
    {
        $this->expectException(EmailInvalid::class);
        $userFirstName = "sergey";
        $userLastName = "rudnev";
        $userEmail = "joe@";
        $userPhone = "123456789";
        $command = new CreateUserCommand($userFirstName, $userLastName, $userEmail, $userPhone);
        $command->setUserId(1);
        $this->service->addUser($command);
    }



}