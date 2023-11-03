<?php

declare(strict_types=1);

namespace App\Domain\Inventory\Repository;

use App\Domain\Inventory\Model\Inventory;
use App\Domain\Shared\Repository\RepositoryInterface;

interface InventoryRepositoryInterface extends RepositoryInterface
{
    public function save(Inventory $inventory): void;

    public function remove(Inventory $inventory): void;

    public function find(int $id): ?Inventory;
}
