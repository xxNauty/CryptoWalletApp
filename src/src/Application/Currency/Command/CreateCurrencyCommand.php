<?php

declare(strict_types=1);

namespace App\Application\Currency\Command;

use App\Application\Shared\Command\CommandInterface;
use Webmozart\Assert\Assert;

class CreateCurrencyCommand implements CommandInterface
{
    public function __construct(
        public string $symbol,
        public readonly string $name,
        public readonly float $startPriceUSD,
    ) {
        Assert::length($this->symbol, 3);
        Assert::alpha($this->symbol);
        $this->symbol = strtoupper($this->symbol);
    }
}
