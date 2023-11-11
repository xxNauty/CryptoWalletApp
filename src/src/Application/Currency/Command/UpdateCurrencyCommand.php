<?php

declare(strict_types=1);

namespace App\Application\Currency\Command;

use App\Domain\Shared\Command\CommandInterface;

class UpdateCurrencyCommand implements CommandInterface
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
