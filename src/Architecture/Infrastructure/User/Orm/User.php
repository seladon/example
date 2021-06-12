<?php

namespace Architecture\Infrastructure\User\Orm;

use Architecture\Infrastructure\Repository\User\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email")
 * @UniqueEntity("phone")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $keyCloakId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="boolean", options={"default":"0"}, nullable=true)
     */
    private $checkPhone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean", options={"default":"0"}, nullable=true)
     */
    private $checkEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;


    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     * @return User
     */
    public function setFirstName($firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     * @return User
     */
    public function setLastName($lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKeyCloakId()
    {
        return $this->keyCloakId;
    }

    /**
     * @param mixed $keyCloakId
     */
    public function setKeyCloakId($keyCloakId): User
    {
        $this->keyCloakId = $keyCloakId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): User
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCheckPhone()
    {
        return $this->checkPhone;
    }

    /**
     * @param mixed $checkPhone
     */
    public function setCheckPhone($checkPhone): User
    {
        $this->checkPhone = $checkPhone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCheckEmail()
    {
        return $this->checkEmail;
    }

    /**
     * @param mixed $checkEmail
     */
    public function setCheckEmail($checkEmail): User
    {
        $this->checkEmail = $checkEmail;
        return $this;
    }

}
