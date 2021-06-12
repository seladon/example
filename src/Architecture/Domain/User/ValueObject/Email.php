<?php
declare(strict_types=1);

namespace Architecture\Domain\User\ValueObject;


use Architecture\Domain\User\Exception\EmailInvalid;

/**
 * Class Email
 *
 * @package Architecture\Domain\User\ValueObject
 */
class Email
{
    /**
     * @var string
     */
    private string $emailString;

    /**
     * @var bool
     */
    private bool $confirmEmail = false;


    private function __construct(string $emailString)
    {
        $this->emailString = $emailString;
    }
    /**
     * @param string $emailString
     * @return Email
     */
    public static function create(string $emailString): Email
    {
        if (!self::isValidEmail($emailString)) {
            throw new EmailInvalid("Invalid email");
        }
        return new self($emailString);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->emailString;
    }

    /**
     * @param $email
     * @return bool
     */
    private static function isValidEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * @return bool
     */
    public function isConfirmEmail(): bool
    {
        return $this->confirmEmail;
    }

    /**
     * @param bool $confirmEmail
     */
    public function setConfirmEmail(bool $confirmEmail): void
    {
        $this->confirmEmail = $confirmEmail;
    }

}