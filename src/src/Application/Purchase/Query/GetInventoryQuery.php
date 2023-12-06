<?php

namespace App\Application\Purchase\Query;

use App\Domain\Shared\Query\QueryInterface;
use App\Domain\User\Model\User;

readonly class GetInventoryQuery implements QueryInterface
{
    public function __construct(
        public User $user
    ) {
    }
}
