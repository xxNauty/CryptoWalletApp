<?php

namespace App\Application\Inventory\Command;

use App\Domain\Shared\Command\CommandInterface;
use Webmozart\Assert\Assert;

class UpdateUserInventoryCommand implements CommandInterface
{
    public function __construct(
        public string $action,
        public string $symbol,
        public float $amount,
    ) {
        Assert::inArray($this->action, ['buy', 'sell']);
        Assert::lengthBetween($this->symbol, 3, 4);
    }
}
