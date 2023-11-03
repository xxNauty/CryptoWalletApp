<?php

declare(strict_types=1);

namespace App\Application\Currency\Command;

use App\Application\Shared\Command\CommandInterface;

class DeleteCurrencyCommand implements CommandInterface
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
