<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Domain\Shared\Command\CommandInterface;

class DeleteUserCommand implements CommandInterface
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
