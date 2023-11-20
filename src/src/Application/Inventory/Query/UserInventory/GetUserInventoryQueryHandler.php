<?php

declare(strict_types=1);

namespace App\Application\Inventory\Query\UserInventory;

use App\Domain\Shared\Query\QueryHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Security;

class GetUserInventoryQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly Security $security,
    ) {
    }

    public function __invoke(GetUserInventoryQuery $query): array
    {
        $inventory = $this->userRepository->find($this->security->getUser()->id)->inventory;

        $details = [];
        foreach ($inventory->content as $key => $value) {
            $details[] = [$key => $value];
        }

        // todo ogarnąć to jakoś lepiej
        return [
            'totalInventoryValue' => ['totalInventoryValue' => $inventory->totalInventoryValue],
            'details' => ['details' => $details],
        ];
    }
}
