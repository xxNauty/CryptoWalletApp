<?php

declare(strict_types=1);

namespace App\Application\User\Query;

use App\Application\Shared\Query\QueryInterface;

class FindUserCollectionQuery implements QueryInterface
{
    public function __construct(
        public readonly ?string $firstName = null,
        public readonly ?int $page = null,
        public readonly ?int $itemsPerPage = null,
    ) {
    }
}
