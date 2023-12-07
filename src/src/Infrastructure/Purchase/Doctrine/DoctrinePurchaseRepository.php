<?php

namespace App\Infrastructure\Purchase\Doctrine;

use App\Domain\Purchase\Model\Purchase;
use App\Domain\Purchase\Resource\PurchaseRepositoryInterface;
use App\Domain\User\Model\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class DoctrinePurchaseRepository implements PurchaseRepositoryInterface
{
    private const ENTITY_CLASS = Purchase::class;
    private const ALIAS = 'purchase';

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

    public function save(Purchase $purchase): void
    {
        $this->em->persist($purchase);
        $this->em->flush();
    }

    public function remove(Purchase $purchase): void
    {
        $this->em->remove($purchase);
        $this->em->flush();
    }

    public function find(int $id): ?Purchase
    {
        return $this->em->find(self::ENTITY_CLASS, $id);
    }

    public function getAmountOfCurrency(User $user, string $symbol): float
    {
        $bought = $this->query()
            ->select(sprintf('sum(%s.amount)', self::ALIAS))
            ->where(sprintf('%s.owner = :owner', self::ALIAS))
            ->andWhere(sprintf('%s.sold = false', self::ALIAS))
            ->andWhere(sprintf('%s.symbol = :symbol', self::ALIAS))
            ->setParameter('owner', $user)
            ->setParameter('symbol', $symbol)
            ->getQuery()
            ->getResult();

        $sold = $this->query()
            ->select(sprintf('sum(%s.amount)', self::ALIAS))
            ->where(sprintf('%s.owner = :owner', self::ALIAS))
            ->andWhere(sprintf('%s.sold = true', self::ALIAS))
            ->andWhere(sprintf('%s.symbol = :symbol', self::ALIAS))
            ->setParameter('owner', $user)
            ->setParameter('symbol', $symbol)
            ->getQuery()
            ->getResult();

        return floatval(bcsub($bought[0]['1'], $sold[0]['1'], 10));
    }

    public function getUsersCurrencies(User $user): array
    {
        $data = $this->query()
            ->select(sprintf('%s.symbol', self::ALIAS))
            ->where(sprintf('%s.owner = :owner', self::ALIAS))
            ->setParameter('owner', $user)
            ->getQuery()
            ->getResult();

        $returnArray = [];

        foreach ($data as $item) {
            $returnArray[] = $item['symbol'];
        }

        return array_unique($returnArray);
    }

    public function findUsedCurrencies(): ?array
    {
        $data = $this->query()
            ->select(sprintf('%s.symbol', self::ALIAS))
            ->getQuery()
            ->getResult();

        $returnArray = [];

        foreach ($data as $item) {
            $returnArray[] = $item['symbol'];
        }

        return array_unique($returnArray);
    }

    public function findBy(array $params): ?array
    {
        return $this->em->getRepository(self::ENTITY_CLASS)->findBy($params);
    }
}
