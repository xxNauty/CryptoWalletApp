<?php

declare(strict_types=1);

namespace App\Application\Purchase\Query;

use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Purchase\Resource\PurchaseRepositoryInterface;
use App\Domain\Purchase\ValueObject\InventoryPart;
use App\Domain\Shared\Query\QueryHandlerInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;
use Webmozart\Assert\Assert;

readonly class GetCurrencyAmountQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserSecurityServiceInterface $securityService,
        private PurchaseRepositoryInterface $purchaseRepository,
        private CurrencyRepositoryInterface $currencyRepository
    ) {
    }

    public function __invoke(GetCurrencyAmountQuery $query): InventoryPart
    {
        $user = $this->securityService->getUser();

        Assert::inArray(
            $query->symbol,
            $this->purchaseRepository->getUsersCurrencies($user)
        );

        $amount = $this->purchaseRepository->getAmountOfCurrency($user, $query->symbol);

        return new InventoryPart(
            $query->symbol,
            $amount,
            floatval(
                bcmul(
                    strval($amount),
                    strval($this->currencyRepository->findBy(['symbol' => $query->symbol])->priceUSD),
                    10
                )
            )
        );
    }
}
