<?php

declare(strict_types=1);

namespace App\Application\Inventory\Query;

use App\Application\Shared\Query\QueryInterface;

class FindInventoryCollectionQuery implements QueryInterface
{
    public function __construct(
        public readonly ?int $page = null,
        public readonly ?int $itemsPerPage = null,
    ) {
    }
}