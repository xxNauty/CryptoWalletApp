<?php

namespace App\Application\User\Query;

use App\Domain\Shared\Query\QueryInterface;
use App\Domain\User\Model\User;

readonly class FindOwnDataQuery implements QueryInterface
{
    public function __construct(
        public User $user
    ) {
    }
}
