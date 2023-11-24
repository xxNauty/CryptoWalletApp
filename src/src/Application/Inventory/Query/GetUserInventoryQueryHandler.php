<?php

declare(strict_types=1);

namespace App\Application\Inventory\Query;

use App\Domain\Shared\Query\QueryHandlerInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;

readonly class GetUserInventoryQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserSecurityServiceInterface $securityService
    ) {
    }

    public function __invoke(GetUserInventoryQuery $query): array
    {
        $inventory = $this->securityService->getUser()?->inventory;

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
