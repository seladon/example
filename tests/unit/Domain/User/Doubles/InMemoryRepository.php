<?php
declare(strict_types=1);

namespace Tests\unit\Domain\User\Doubles;


use Architecture\Domain\User\Entity\User;
use Architecture\Domain\User\Repository\UserRepositoryInterface;

class InMemoryRepository implements UserRepositoryInterface
{

    /**
     * @var User[] $cache
     */
    private array $cache = [];

    /**
     * @param User $user
     * @return int
     */
    public function persist(User $user) : int
    {
        $user->setId(array_key_last($this->cache)+1);
        $this->cache[] = $user;
        return $user->getId();
    }

    /**
     * @return User[]
     */
    public function getAll(): array
    {
        return $this->cache;
    }

    /**
     * @param int $userId
     * @return User|null
     */
    public function getUserById(int $userId): ?User
    {
        foreach ($this->cache as $user) {
            if ($user->getId() == $userId) {
                return $user;
            }
        }
        return null;
    }

    /**
     * @param string $userEmail
     * @return User|null
     */
    public function getUserByUserEmail(string $userEmail): ?User
    {
        foreach ($this->cache as $user) {
            if ($user->getEmail()->getEmail() == $userEmail) {
                return $user;
            }
        }
        return null;
    }
}