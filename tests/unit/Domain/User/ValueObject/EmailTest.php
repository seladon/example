<?php
declare(strict_types=1);

namespace Tests\unit\Domain\User\ValueObject;


use Architecture\Domain\User\Exception\EmailInvalid;
use Architecture\Domain\User\ValueObject\Email;
use Codeception\PHPUnit\TestCase;

class EmailTest extends TestCase
{

    /**
     * @dataProvider emailProvider
     * @param $a
     * @param $expected
     */
    public function testCreateEmail($a, $expected)
    {
        $email = Email::create($a);
        $this->assertSame($expected, $email->getEmail());
        $this->assertInstanceOf(Email::class, $email);
    }

    public function testEmailEmpty()
    {
        $this->expectException(EmailInvalid::class);
        Email::create("");
    }


    public function testEmailInvalid()
    {
        $this->expectException(EmailInvalid::class);
        Email::create("ru@yandex");
    }

    public function emailProvider(): array
    {
        return [
            ["ru@ru.ru", "ru@ru.ru"],
            ["ru@yandex.ru", "ru@yandex.ru"],
        ];
    }

}