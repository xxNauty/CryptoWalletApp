<?php

declare(strict_types=1);

namespace App\Application\User\Query;

use App\Application\Shared\Query\QueryHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;

class FindUsersQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(FindUsersQuery $query): UserRepositoryInterface
    {
        $userRepository = $this->userRepository;

        if (null !== $query->firstName) {
            $userRepository = $userRepository->withFirstName($query->firstName);
        }

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $userRepository = $userRepository->withPagination($query->page, $query->itemsPerPage);
        }

        return $userRepository;
    }
}
