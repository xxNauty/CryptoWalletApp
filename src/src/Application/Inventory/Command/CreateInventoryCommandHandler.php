<?php

declare(strict_types=1);

namespace App\Application\Inventory\Command;

use App\Application\Shared\Command\CommandHandlerInterface;
use App\Domain\Inventory\Model\Inventory;
use App\Domain\Inventory\Repository\InventoryRepositoryInterface;

class CreateInventoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly InventoryRepositoryInterface $inventoryRepository
    ) {
    }

    public function __invoke(CreateInventoryCommand $command): Inventory
    {
        $inventory = new Inventory(
            $command->owner
        );

        $this->inventoryRepository->save($inventory);

        return $inventory;
    }
}
