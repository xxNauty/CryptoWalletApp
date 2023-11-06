<?php

declare(strict_types=1);

namespace App\Application\Currency\Query;

use App\Domain\Shared\Query\QueryInterface;

class FindCurrencyQuery implements QueryInterface
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
