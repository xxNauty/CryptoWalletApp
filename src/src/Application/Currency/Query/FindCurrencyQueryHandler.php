<?php

declare(strict_types=1);

namespace App\Application\Currency\Query;

use App\Domain\Shared\Query\QueryHandlerInterface;

class FindCurrencyQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        //        private readonly CurrencyRepositoryInterface $currencyRepository,
        //        private readonly UserSecurityServiceInterface $securityService,
        //        private readonly DolarRatioManagerInterface $dollarRatioManager,
    ) {
    }

    public function __invoke(FindCurrencyQuery $query): null
    {
        //        $currency = $this->currencyRepository->find($query->id);
        //
        //        $currencyToConvert = $this->securityService->getUser()?->currency;
        //        if (null == $currencyToConvert) {
        //            return new CryptoCurrency(
        //                $currency->id,
        //                $currency->symbol,
        //                $currency->name,
        //                $currency->priceUSD,
        //                $currency->change1h,
        //                $currency->change24h,
        //                $currency->change7d
        //            );
        //        }
        //
        //        $ratio = 0;
        //        if (DolarRatio::DEFAULT_CURRENCY != $currencyToConvert) {
        //            $ratio = $this->dollarRatioManager->getData($currencyToConvert)['ratio'];
        //        }
        //
        //        return new ExtendedCryptoCurrency(
        //            $currency->id,
        //            $currency->symbol,
        //            $currency->name,
        //            $currency->priceUSD,
        //            floatval(bcmul(strval($currency->priceUSD), strval($ratio), 10)),
        //            $currencyToConvert,
        //            $currency->change1h,
        //            $currency->change24h,
        //            $currency->change7d
        //        );
        return null; // todo do poprawy
    }
}
