<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\Shared\Command\CommandInterface;
use Symfony\Component\Uid\Uuid;

final class DeleteUserCommand implements CommandInterface
{
    public function __construct(
        public readonly Uuid $id,
    ) {
    }
}
