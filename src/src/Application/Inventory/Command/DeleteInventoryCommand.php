<?php

declare(strict_types=1);

namespace App\Application\Inventory\Command;

use App\Application\Shared\Command\CommandInterface;

class DeleteInventoryCommand implements CommandInterface
{
    public function __construct(
        public readonly int $id
    ) {
    }
}
