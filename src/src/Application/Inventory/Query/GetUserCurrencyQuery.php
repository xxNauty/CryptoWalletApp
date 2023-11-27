<?php

namespace App\Application\Inventory\Query;

use App\Domain\Shared\Query\QueryInterface;

class GetUserCurrencyQuery implements QueryInterface
{
    public function __construct(
        public string $symbol,
    ) {
    }
}
