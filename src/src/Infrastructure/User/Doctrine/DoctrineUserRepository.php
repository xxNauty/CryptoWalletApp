<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Doctrine;

use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class DoctrineUserRepository implements UserRepositoryInterface
{
    private const ENTITY_CLASS = User::class;
    private const ALIAS = 'user';

    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    public function query(): QueryBuilder
    {
        return $this->em->createQueryBuilder()
            ->select(self::ALIAS)
            ->from(self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function remove(User $user): void
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    public function find(int $id): ?User
    {
        return $this->em->find(self::ENTITY_CLASS, $id);
    }

    public function findByEmail(?string $email): ?User
    {
        if (null != $email) {
            return $this->em->getRepository(self::ENTITY_CLASS)->findOneBy(['email' => $email]);
        }

        return null;
    }

    public function getAll(): ?array
    {
        return $this->em->getRepository(self::ENTITY_CLASS)->findAll();
    }
}
