<?php

declare(strict_types=1);

namespace App\Application\Inventory\Command;

use App\Domain\Inventory\Model\Inventory;
use App\Domain\Inventory\Repository\InventoryRepositoryInterface;
use App\Domain\Shared\Command\CommandHandlerInterface;

class CreateInventoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly InventoryRepositoryInterface $inventoryRepository,
    ) {
    }

    public function __invoke(CreateInventoryCommand $command): Inventory
    {
        $inventory = new Inventory(
            $command->owner
        );

        $command->owner->inventory = $inventory;

        $this->inventoryRepository->save($inventory);

        return $inventory;
    }
}
