<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Doctrine;

use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Shared\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class DoctrineUserRepository extends DoctrineRepository implements UserRepositoryInterface
{
    private const ENTITY_CLASS = User::class;
    private const ALIAS = 'user';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
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

    public function withFirstName(string $firstName): static
    {
        return $this->filter(static function (QueryBuilder $qb) use ($firstName): void {
            $qb->where(sprintf('%s.firstName = :firstName', self::ALIAS))->setParameter('firstName', $firstName);
        });
    }

    public function findByEmail(string $email): ?User
    {
        return $this->em->getRepository(self::ENTITY_CLASS)->findOneBy(['email' => $email]);
    }
}
