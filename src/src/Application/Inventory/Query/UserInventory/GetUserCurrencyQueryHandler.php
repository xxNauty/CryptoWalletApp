<?php

namespace App\Application\Inventory\Query\UserInventory;

use App\Domain\Shared\Query\QueryHandlerInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetUserCurrencyQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly UserSecurityServiceInterface $securityService
    ) {
    }

    public function __invoke(GetUserCurrencyQuery $query): array
    {
        $inventory = $this->securityService->getUser()?->inventory;

        if (!array_key_exists($query->symbol, $inventory->content)) {
            throw new NotFoundHttpException('You do not have this currency');
        }

        return [$query->symbol => $inventory->content[$query->symbol]];
    }
}
