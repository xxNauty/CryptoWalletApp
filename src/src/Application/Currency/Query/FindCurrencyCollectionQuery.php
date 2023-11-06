<?php

declare(strict_types=1);

namespace App\Application\Currency\Query;

use App\Domain\Shared\Query\QueryInterface;

class FindCurrencyCollectionQuery implements QueryInterface
{
    public function __construct(
        public readonly ?int $page = null,
        public readonly ?int $itemsPerPage = null,
    ) {
    }
}
