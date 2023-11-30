<?php

namespace App\Application\User\Command;

use App\Domain\Shared\Command\CommandBusInterface;
use App\Domain\Shared\Command\CommandInterface;

class UpdateUserPasswordCommand implements CommandInterface
{
    public function __construct(
        public readonly string $oldPassword,
        public readonly string $newPassword,
    )
    {
    }
}