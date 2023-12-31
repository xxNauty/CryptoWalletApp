<?php

declare(strict_types=1);

namespace App\Application\User\Query;

use App\Domain\Shared\Query\QueryInterface;

readonly class FindUserQuery implements QueryInterface
{
    public function __construct(
        public int $id,
    ) {
    }
}
