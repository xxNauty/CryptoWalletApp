<?php

namespace App\Infrastructure\Purchase\Doctrine;

use App\Domain\Purchase\Model\Purchase;
use App\Domain\Purchase\Resource\PurchaseRepositoryInterface;
use App\Infrastructure\Shared\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrinePurchaseRepository extends DoctrineRepository implements PurchaseRepositoryInterface
{
    private const ENTITY_CLASS = Purchase::class;
    private const ALIAS = 'purchase';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
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
}
