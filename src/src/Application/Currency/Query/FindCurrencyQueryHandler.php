<?php

declare(strict_types=1);

namespace App\Application\Currency\Query;

use App\Application\Currency\DTO\ExtendedCryptoCurrency;
use App\Domain\Currency\Model\DolarRatio;
use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Currency\Service\DolarRatioManagerInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;

class FindCurrencyQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository,
        private readonly UserSecurityServiceInterface $securityService,
        private readonly DolarRatioManagerInterface $dollarRatioManager
    ) {
    }

    public function __invoke(FindCurrencyQuery $query): ?ExtendedCryptoCurrency
    {
        $currencyToConvert = $this->securityService->getUser()?->currency;
        $ratio = 0;
        if (null != $currencyToConvert && DolarRatio::DEFAULT_CURRENCY != $currencyToConvert) {
            $ratio = $this->dollarRatioManager->getData($currencyToConvert)['ratio'];
        }
        $currency = $this->currencyRepository->find($query->id);

        return new ExtendedCryptoCurrency(
            $currency->id,
            $currency->symbol,
            $currency->name,
            $currency->priceUSD,
            $currency->priceUSD * $ratio,
            $currencyToConvert ?? '',
            $currency->change1h,
            $currency->change24h,
            $currency->change7d
        );
    }
}
