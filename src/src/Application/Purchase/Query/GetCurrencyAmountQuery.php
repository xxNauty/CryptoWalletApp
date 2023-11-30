<?php

namespace App\Application\Purchase\Query;

use App\Domain\Shared\Query\QueryInterface;

readonly class GetCurrencyAmountQuery implements QueryInterface
{
    public function __construct(
        public string $symbol
    ) {
    }
}
