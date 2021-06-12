<?php
declare(strict_types=1);


namespace Architecture\Infrastructure\User\DTO;


/**
 * Class UserDto
 * @package Architecture\Infrastructure\User\DTO
 */
class UserDto
{
    /** @var int|null $id */
    private ?int $id;

    /** @var string|null $userFirstName */
    private ?string $userFirstName;

    /** @var string|null $userLastName */
    private ?string $userLastName;

    /** @var string|null $userEmail */
    private ?string $userEmail;

    /** @var string|null $phone */
    private ?string $phone;

    /**
     * UserDto constructor.
     *
     * @param int|null $id
     * @param string|null $userFirstName
     * @param string|null $userLastName
     * @param string|null $userEmail
     * @param string|null $phone
     */
    public function __construct(
        ?int $id = null,
        ?string $userFirstName = null,
        ?string $userLastName = null,
        ?string $userEmail = null,
        ?string $phone = null
    )
    {
        $this->id = $id;
        $this->userFirstName = $userFirstName;
        $this->userLastName = $userLastName;
        $this->userEmail = $userEmail;
        $this->phone = $phone;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getUserFirstName(): ?string
    {
        return $this->userFirstName;
    }

    /**
     * @param string|null $userFirstName
     */
    public function setUserFirstName(?string $userFirstName): void
    {
        $this->userFirstName = $userFirstName;
    }

    /**
     * @return string|null
     */
    public function getUserLastName(): ?string
    {
        return $this->userLastName;
    }

    /**
     * @param string|null $userLastName
     */
    public function setUserLastName(?string $userLastName): void
    {
        $this->userLastName = $userLastName;
    }

    /**
     * @return string|null
     */
    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    /**
     * @param string|null $userEmail
     */
    public function setUserEmail(?string $userEmail): void
    {
        $this->userEmail = $userEmail;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }
}