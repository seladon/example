<?php

namespace Architecture\Infrastructure\Repository\User;

use Architecture\Domain\User\Entity\User;
use Architecture\Domain\User\Repository\UserRepositoryInterface;
use Architecture\Domain\User\ValueObject\Email;
use Architecture\Domain\User\ValueObject\Phone;
use Architecture\Infrastructure\User\Orm\User as Orm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * @method Orm|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orm|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orm[]    findAll()
 * @method Orm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orm::class);
    }

    /**
     * @param User $user
     * @return int
     */
    public function persist(User $user): int
    {
        $userOrm = new Orm();
        $userOrm->setFirstName($user->getFirstName())
            ->setLastName($user->getLastName())
            ->setPhone($user->getPhone()->getNumber())
            ->setEmail($user->getEmail()->getEmail());

        try {
            $entityManager = $this->getEntityManager();
            $entityManager->persist($userOrm);
            $entityManager->flush();
            return $userOrm->getId();

        } catch (\Exception $exception) {
            throw new BadRequestException('Произошла ошибка при регистрации пользователя');
        }

    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $users = $this->findAll();
        $result = [];
        foreach ($users as $user) {
            $result[] = (new User())
                ->setPhone((Phone::create($user->getPhone())))
                ->setEmail(Email::create($user->getEmail()))
                ->setFirstName($user->getFirstName())
                ->setLastName($user->getLastName());
        }
        return $result;
    }

    /**
     * @param int $userId
     * @return User|null
     */
    public function getUserById(int $userId): ?User
    {
        $user = $this->find($userId);
        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id ' . $userId
            );
        }

        return (new User())
            ->setId($user->getId())
            ->setPhone((Phone::create($user->getPhone())))
            ->setEmail(Email::create($user->getEmail()))
            ->setFirstName($user->getFirstName())
            ->setLastName($user->getLastName());
    }
}
