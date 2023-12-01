<?php

namespace App\Application\Purchase\Query;

use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Purchase\Resource\PurchaseRepositoryInterface;
use App\Domain\Purchase\ValueObject\InventoryPart;
use App\Domain\Shared\Query\QueryHandlerInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;

readonly class GetInventoryQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserSecurityServiceInterface $securityService,
        private PurchaseRepositoryInterface $purchaseRepository,
        private CurrencyRepositoryInterface $currencyRepository
    ) {
    }

    public function __invoke(GetInventoryQuery $query): ?array
    {
        $user = $this->securityService->getUser();
        $inventory = [];

        $currencies = $this->purchaseRepository->getUsersCurrencies($user);

        foreach ($currencies as $currency) {
            $amount = $this->purchaseRepository->getAmountOfCurrency($user, $currency);
            $inventory[] = new InventoryPart(
                $currency,
                $amount,
                floatval(
                    bcmul(
                        strval($amount),
                        strval($this->currencyRepository->findBy(['symbol' => $currency])->priceUSD),
                        10
                    )
                )
            );
        }

        return $inventory;
    }
}
