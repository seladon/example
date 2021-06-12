<?php
declare(strict_types=1);

namespace Architecture\Domain\User\Repository;


use Architecture\Domain\User\Entity\User;

interface UserRepositoryInterface
{
    public function persist(User $user) : int;

    public function getAll(): array;

    public function getUserById(int $userId): ?User;

}