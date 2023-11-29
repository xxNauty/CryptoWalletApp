<?php

namespace App\Application\Purchase\Query;

use App\Domain\Purchase\Resource\PurchaseRepositoryInterface;
use App\Domain\Purchase\ValueObject\InventoryPart;
use App\Domain\Shared\Query\QueryHandlerInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;
use Webmozart\Assert\Assert;

readonly class GetCurrencyAmountQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserSecurityServiceInterface $securityService,
        private PurchaseRepositoryInterface $purchaseRepository
    ) {
    }

    public function __invoke(GetCurrencyAmountQuery $query): InventoryPart
    {
        $user = $this->securityService->getUser();

        Assert::inArray(
            $query->symbol,
            $this->purchaseRepository->getUsersCurrencies($user)
        );

        return new InventoryPart(
            $query->symbol,
            $this->purchaseRepository->getValueOfCurrency($user, $query->symbol),
        );
    }
}