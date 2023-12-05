<?php

declare(strict_types=1);

namespace App\Application\User\Query;

use App\Domain\Shared\Query\QueryHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;

readonly class FindUserCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function __invoke(FindUserCollectionQuery $query): ?array
    {
        $users = $this->userRepository->getAll();

        $firstElement = $query->page > 1
            ? $query->itemsPerPage + $query->page - 1
            : 0;

        return array_slice($users, $firstElement, $query->itemsPerPage);
    }
}
