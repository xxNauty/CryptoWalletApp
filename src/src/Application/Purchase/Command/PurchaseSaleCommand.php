<?php

namespace App\Application\Purchase\Command;

use App\Domain\Shared\Command\CommandInterface;

readonly class PurchaseSaleCommand implements CommandInterface
{
    public function __construct(
        public string $symbol,
        public float $amount
    ) {
    }
}
