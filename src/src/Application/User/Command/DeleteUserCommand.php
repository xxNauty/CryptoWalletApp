<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Domain\Shared\Command\CommandInterface;

readonly class DeleteUserCommand implements CommandInterface
{
    public function __construct(
        public int $id,
        public string $password,
    ) {
    }
}
