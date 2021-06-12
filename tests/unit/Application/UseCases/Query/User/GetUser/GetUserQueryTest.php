<?php
declare(strict_types=1);

namespace Tests\unit\Application\UseCases\Query\User\GetUser;

use Architecture\Application\UseCases\Command\User\AddUser\CreateUserCommand;
use Architecture\Application\UseCases\Query\User\GetUser\GetUserQuery;
use Codeception\PHPUnit\TestCase;
use Symfony\Component\Validator\Constraints as Assert;
use Architecture\Application\UseCases\Command\CommandInterface;

/**
 * Class GetUserQueryTest
 *
 * @package Tests\unit\Application\UseCases\Query\User\GetUser
 */
class GetUserQueryTest extends TestCase
{

    public function testCommandCanBeCreate()
    {
        $userId = 1;
        $command = new GetUserQuery($userId);
        $this->assertSame($userId, $command->getUserId());
    }
}