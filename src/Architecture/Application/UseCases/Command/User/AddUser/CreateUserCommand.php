<?php
declare(strict_types=1);

namespace Architecture\Application\UseCases\Command\User\AddUser;

use Symfony\Component\Validator\Constraints as Assert;
use Architecture\Application\UseCases\Command\CommandInterface;

/**
 * Class CreateUserCommand
 *
 * @package Architecture\Application\UseCases\Command\User\AddUser
 */
class CreateUserCommand implements CommandInterface
{

    /**
     * @Assert\Type(type = "string")
     * @var int
     */
    public $userId;

    /**
     * @Assert\Type(type = "string")
     * @var string
     */
    public $userFirstName;
    /**
     * @Assert\Type(type = "string")
     * @var string
     */
    public $userLastName;
    /**
     * @Assert\Type(type = "string")
     * @var string
     */
    public $userEmail;

    /**
     * @Assert\Type(type = "string")
     * @Assert\NotBlank
     * @var string
     */
    public $phone;
    /**
     * @Assert\Type(type = "string")
     * @var string
     */
    public $traceId;

    /**
     * CreateUserCommand constructor.

     * @param string $userFirstName
     * @param string $userLastName
     * @param string $userEmail
     * @param string $phone
     */
    public function __construct(
        string $userFirstName,
        string $userLastName,
        string $userEmail,
        string $phone
    )
    {
        $this->userEmail = $userEmail;
        $this->userFirstName = $userFirstName;
        $this->userLastName = $userLastName;
        $this->phone = $phone;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getUserFirstName(): string
    {
        return $this->userFirstName;
    }

    /**
     * @return string
     */
    public function getUserLastName(): string
    {
        return $this->userLastName;
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    /**
     * @return string
     */
    public function getTraceId(): string
    {
        return $this->traceId;
    }

    /**
     * @param string $traceId
     */
    public function setTraceId(string $traceId): void
    {
        $this->traceId = $traceId;
    }
}