<?php
namespace Tests\unit\Domain\User\Event;

use Architecture\Domain\User\Event\UserWasAdd;
use Codeception\PHPUnit\TestCase;

class UserWasAddTest extends TestCase
{
    public function testCreate()
    {
        $userId = 1;
        $event = new UserWasAdd($userId);
        $this->assertSame($userId, $event->getUserId());

        $data = $event->serialize();
        $this->assertSame(['id' => $userId], $data);

        $data = UserWasAdd::deserialize(['id' => $userId]);
        $this->assertSame($userId, $data->getUserId());
    }
}