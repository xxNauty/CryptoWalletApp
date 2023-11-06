<?php

declare(strict_types=1);

namespace App\Application\Inventory\Query;

use App\Domain\Inventory\Model\Inventory;
use App\Domain\Inventory\Repository\InventoryRepositoryInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;

class FindInventoryQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly InventoryRepositoryInterface $inventoryRepository,
    ) {
    }

    public function __invoke(FindInventoryQuery $query): ?Inventory
    {
        return $this->inventoryRepository->find($query->id);
    }
}
