<?php

namespace App\Application\Purchase\Command;

use App\Domain\Shared\Command\CommandInterface;
use Webmozart\Assert\Assert;

readonly class PurchaseCommand implements CommandInterface
{
    public function __construct(
        public string $symbol,
        public float $amount
    ) {
    }
}
