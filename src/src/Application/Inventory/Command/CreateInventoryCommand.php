<?php

declare(strict_types=1);

namespace App\Application\Inventory\Command;

use App\Application\Shared\Command\CommandInterface;
use App\Domain\User\Model\User;

class CreateInventoryCommand implements CommandInterface
{
    public function __construct(
        public readonly User $owner,
    ) {
    }
}
