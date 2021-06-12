<?php
declare(strict_types=1);

namespace Tests\unit\Application\UseCases\Command\User\AddUser;

use Architecture\Application\UseCases\Command\User\AddUser\CreateUserCommand;
use Codeception\PHPUnit\TestCase;
use Symfony\Component\Validator\Constraints as Assert;
use Architecture\Application\UseCases\Command\CommandInterface;

/**
 * Class CreateUserCommandTest
 *
 * @package Tests\unit\Application\UseCases\Command\User\AddUser
 */
class CreateUserCommandTest  extends TestCase
{

    public function testCommandCanBeCreate()
    {
        $userFirstName = "sergey";
        $userLastName = "rudnev";
        $userEmail = "joe@example.com";
        $userPhone = "123456789";
        $command = new CreateUserCommand($userFirstName, $userLastName, $userEmail, $userPhone);
        $this->assertSame($userEmail, $command->getUserEmail());
        $this->assertSame($userFirstName, $command->getUserFirstName());
        $this->assertSame($userLastName, $command->getUserLastName());
        $this->assertSame($userPhone, $command->getPhone());
    }

}