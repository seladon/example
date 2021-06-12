<?php
declare(strict_types=1);

namespace Tests\unit\Domain\User\ValueObject;

use Codeception\PHPUnit\TestCase;
use Architecture\Domain\User\Exception\PhoneLengthInvalid;
use Architecture\Domain\User\ValueObject\Phone;

class PhoneTest extends TestCase
{
    /**
     * @dataProvider phoneProvider
     * @param $a
     * @param $b
     * @param $c
     * @param $expected
     */
    public function testCreatePhone($a, $expected)
    {
        $phone = Phone::create($a);
        $this->assertSame($expected, $phone->getNumber());
    }

    /**
     * @dataProvider phoneErrorProvider
     * @param $a
     * @param $b
     * @param $c
     * @param $expected
     */
    public function testPhoneNumberEmpty($a, $expected)
    {
        $this->expectException($expected);
        Phone::create($a);
    }

    public function phoneProvider(): array
    {
        return [
            ["+7 (926) 999 99 99", "+7 (926) 999 99 99"],
            ["+7 (926) 9999999", "+7 (926) 9999999"],
        ];
    }

    public function phoneErrorProvider(): array
    {
        return [
            ["555", PhoneLengthInvalid::class],
            ["123456789114", PhoneLengthInvalid::class],
        ];
    }
}