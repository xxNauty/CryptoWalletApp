<?php

namespace App\Application\User\Query;

use App\Domain\Shared\Query\QueryHandlerInterface;
use App\Domain\User\Model\User;

readonly class FindOwnDataQueryHandler implements QueryHandlerInterface
{
    public function __construct()
    {
    }

    public function __invoke(FindOwnDataQuery $query): User
    {
        return $query->user;
    }
}
