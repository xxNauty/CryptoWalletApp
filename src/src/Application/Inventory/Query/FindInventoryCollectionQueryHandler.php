<?php

declare(strict_types=1);

namespace App\Application\Inventory\Query;

use App\Application\Shared\Query\QueryHandlerInterface;
use App\Domain\Inventory\Repository\InventoryRepositoryInterface;

class FindInventoryCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly InventoryRepositoryInterface $inventoryRepository,
    ) {
    }

    public function __invoke(FindInventoryCollectionQuery $query): ?InventoryRepositoryInterface
    {
        $inventoryRepository = $this->inventoryRepository;

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $inventoryRepository = $inventoryRepository->withPagination($query->page, $query->itemsPerPage);
        }

        return $inventoryRepository;
    }
}
