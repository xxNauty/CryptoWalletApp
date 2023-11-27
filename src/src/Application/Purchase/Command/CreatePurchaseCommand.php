<?php

namespace App\Application\Purchase\Command;

use App\Domain\Shared\Command\CommandInterface;

class CreatePurchaseCommand implements CommandInterface
{
    public function __construct(
        public string $symbol,
        public float $amount,
        public float $singlePrice,
        public \DateTimeImmutable $boughtAt,
        public bool $sold,
    ) {
    }
}
