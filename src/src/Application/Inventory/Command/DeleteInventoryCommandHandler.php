<?php

declare(strict_types=1);

namespace App\Application\Inventory\Command;

use App\Application\Shared\Command\CommandHandlerInterface;
use App\Domain\Inventory\Repository\InventoryRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteInventoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly InventoryRepositoryInterface $inventoryRepository
    ) {
    }

    public function __invoke(DeleteInventoryCommand $command): void
    {
        if (null === $user = $this->inventoryRepository->find($command->id)) {
            throw new NotFoundHttpException('Nie znaleziono portfela o podanym ID');
        }

        $this->inventoryRepository->remove($user);
    }
}
