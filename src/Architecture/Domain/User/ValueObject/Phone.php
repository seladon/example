<?php
declare(strict_types=1);

namespace Architecture\Domain\User\ValueObject;


use Architecture\Domain\User\Exception\PhoneLengthInvalid;

/**
 * Class Phone
 *
 * @package Architecture\Domain\User\ValueObject
 */
class Phone
{
    const PHONE_LENGTH_MAX = 11;
    const PHONE_LENGTH_MIN = 9;

    /**
     * @var string|null
     */
    private ?string $phone;

    /**
     * Phone constructor.
     * @param string $phone
     */
    private function __construct(string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * @param string $phone
     * @return Phone
     */
    public static function create(string $phone): self
    {
        if (mb_strlen(preg_replace('/[^0-9]/', '', $phone)) > self::PHONE_LENGTH_MAX) {
            throw new PhoneLengthInvalid(
                sprintf("The maximum length phone number %d", self::PHONE_LENGTH_MAX)
            );
        }

        if (mb_strlen(preg_replace('/[^0-9]/', '', $phone)) < self::PHONE_LENGTH_MIN) {
            throw new PhoneLengthInvalid(
                sprintf("The minimum length phone number %d", self::PHONE_LENGTH_MIN)
            );
        }

        return new self($phone);
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->phone;
    }

}