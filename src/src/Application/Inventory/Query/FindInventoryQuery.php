<?php

declare(strict_types=1);

namespace App\Application\Inventory\Query;

use App\Domain\Shared\Query\QueryInterface;

class FindInventoryQuery implements QueryInterface
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
