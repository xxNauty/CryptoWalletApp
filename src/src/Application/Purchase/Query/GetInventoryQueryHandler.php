<?php

namespace App\Application\Purchase\Query;

use App\Domain\Purchase\Resource\PurchaseRepositoryInterface;
use App\Domain\Purchase\ValueObject\InventoryPart;
use App\Domain\Shared\Query\QueryHandlerInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;

readonly class GetInventoryQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserSecurityServiceInterface $securityService,
        private PurchaseRepositoryInterface $purchaseRepository
    ) {
    }

    public function __invoke(GetInventoryQuery $query): ?array
    {
        $user = $this->securityService->getUser();
        $inventory = [];

        $currencies = $this->purchaseRepository->getUsersCurrencies($user);

        foreach ($currencies as $currency) {
            $inventory[] = new InventoryPart(
                $currency,
                $this->purchaseRepository->getValueOfCurrency($user, $currency),
            );
        }

        return $inventory;
    }
}
