<?php

declare(strict_types=1);

namespace App\Application\User\Query;

use App\Domain\Shared\Query\QueryInterface;

class FindUserQuery implements QueryInterface
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
