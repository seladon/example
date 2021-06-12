<?php
declare(strict_types=1);

namespace Tests\unit\Application\UseCases\Command\User\AddUser;


use Architecture\Application\UseCases\Command\User\AddUser\CreateUserCommand;
use Architecture\Application\UseCases\Command\User\AddUser\CreateUserHandler;
use Architecture\Domain\User\Exception\CouldNotConfirmEmail;
use Architecture\Domain\User\Repository\UserRepositoryInterface;
use Architecture\Domain\User\Service\UserService;
use Architecture\Infrastructure\Shared\Core\Domain\DomainEventPublisher;
use Codeception\PHPUnit\TestCase;
use Psr\Log\LoggerInterface;
use Tests\unit\Domain\User\Doubles\InMemoryRepository;


class CreateUserHandlerTest  extends TestCase
{
    protected UserRepositoryInterface $repository;
    protected UserService $service;

    public function testCommandCanBeCreate()
    {
        $stub = $this->createMock(DomainEventPublisher::class);
        $this->repository = new InMemoryRepository();
        $this->service = new UserService($this->repository, $stub);
        $handler = new CreateUserHandler($this->service);
        $userFirstName = "sergey";
        $userLastName = "rudnev";
        $userEmail = "joe@example.com";
        $userPhone = "+79261167248";
        $command = new CreateUserCommand($userFirstName, $userLastName, $userEmail, $userPhone);
        $handler($command);
    }

    public function testCommandCanNotBeCreate()
    {
        $this->expectException(\Exception::class);
        $stub = $this->createMock(DomainEventPublisher::class);
        $this->repository = new InMemoryRepository();
        $this->service = new UserService($this->repository, $stub);
        $handler = new CreateUserHandler($this->service);
        $userFirstName = "sergey";
        $userLastName = "rudnev";
        $userEmail = "joe";
        $userPhone = "123456789";
        $command = new CreateUserCommand($userFirstName, $userLastName, $userEmail, $userPhone);
        $handler($command);
    }

}