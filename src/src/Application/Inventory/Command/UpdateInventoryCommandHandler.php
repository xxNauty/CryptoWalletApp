<?php

declare(strict_types=1);

namespace App\Application\Inventory\Command;

use App\Application\Shared\Command\CommandHandlerInterface;
use App\Domain\Inventory\Model\Inventory;
use App\Domain\Inventory\Repository\InventoryRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateInventoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly InventoryRepositoryInterface $inventoryRepository
    ) {
    }

    public function __invoke(UpdateInventoryCommand $command): Inventory
    {
        $inventory = $this->inventoryRepository->find($command->id);

        if (null === $inventory) {
            throw new NotFoundHttpException('Nie znaleziono użytkownika o podanym ID');
        }

        $inventory->owner = $command->owner ?? $inventory->owner;

        $this->inventoryRepository->save($inventory);

        return $inventory;
    }
}
