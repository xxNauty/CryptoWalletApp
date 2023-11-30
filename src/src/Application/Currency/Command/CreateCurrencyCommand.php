<?php

declare(strict_types=1);

namespace App\Application\Currency\Command;

use App\Domain\Shared\Command\CommandInterface;

readonly class CreateCurrencyCommand implements CommandInterface
{
    public function __construct(
        public int $apiId,
    ) {
    }
}
