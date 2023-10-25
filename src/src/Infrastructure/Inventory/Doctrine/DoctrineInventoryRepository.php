<?php

declare(strict_types=1);

namespace App\Infrastructure\Inventory\Doctrine;

use App\Domain\Inventory\Model\Inventory;
use App\Domain\Inventory\Repository\InventoryRepositoryInterface;
use App\Infrastructure\Shared\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineInventoryRepository extends DoctrineRepository implements InventoryRepositoryInterface
{
    private const ENTITY_CLASS = Inventory::class;
    private const ALIAS = 'inventory';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(Inventory $inventory): void
    {
        $this->em->persist($inventory);
        $this->em->flush();
    }

    public function remove(Inventory $inventory): void
    {
        $this->em->remove($inventory);
        $this->em->flush();
    }

    public function find(int $id): ?Inventory
    {
        return $this->em->find(self::ENTITY_CLASS, $id);
    }
}
