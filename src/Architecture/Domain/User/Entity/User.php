<?php
declare(strict_types=1);

namespace Architecture\Domain\User\Entity;


use Architecture\Domain\User\Event\UserWasAdd;
use Architecture\Infrastructure\Shared\Core\Domain\DomainEventAggregate;
use Architecture\Domain\User\ValueObject\Email;
use Architecture\Domain\User\ValueObject\Phone;

/**
 * Class User
 *
 * @package Architecture\Domain\User
 */
class User extends DomainEventAggregate
{
    /**
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @var int|null
     */
    private ?int $keyCloakId = null;

    /**
     * @var Phone|null
     */
    private ?Phone $phone;

    /**
     * @var Email|null
     */
    private ?Email $email;

    /**
     * @var string|null
     */
    private ?string $firstName;

    /**
     * @var string|null
     */
    private ?string $lastName;

    /**
     * @return User
     */
    public static function create(): User
    {
        return new self();
    }

    /**
     * @param string|null $firstName
     * @return User
     */
    public function setFirstName(?string $firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @param string|null $lastName
     * @return User
     */
    public function setLastName(?string $lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return Phone
     */
    public function getPhone(): Phone
    {
        return $this->phone;
    }

    /**
     * @param Phone $phone
     * @return User
     */
    public function setPhone(Phone $phone): User
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @param Email $email
     * @return User
     */
    public function setEmail(Email $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getKeyCloakId(): ?int
    {
        return $this->keyCloakId;
    }

    /**
     * @param int|null $keyCloakId
     * @return User
     */
    public function setKeyCloakId(?int $keyCloakId): User
    {
        $this->keyCloakId = $keyCloakId;
        return $this;
    }

    /**
     * @param int|null $id
     * @return User
     */
    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     */
    public function wasAdd(): void
    {
        $this->apply(new UserWasAdd($this->id));
    }


    public function applyUserWasAdd(UserWasAdd $wasAdd)
    {
        //todo
    }
}