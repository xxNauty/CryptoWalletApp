<?php

declare(strict_types=1);

namespace App\Application\Currency\Query;

use App\Application\Currency\DTO\ExtendedCryptoCurrency;
use App\Domain\Currency\Model\CryptoCurrency;
use App\Domain\Currency\Model\DolarRatio;
use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Currency\Service\DolarRatioManagerInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;
use Symfony\Component\Security\Core\Security;

class FindCurrencyQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository,
        private readonly Security $security,
        private readonly DolarRatioManagerInterface $dollarRatioManager
    ) {
    }

    public function __invoke(FindCurrencyQuery $query): ?ExtendedCryptoCurrency
    {
        $currencyToConvert = $this->security->getUser()?->currency;
        $ratio = 0;
        if($currencyToConvert != null && $currencyToConvert != DolarRatio::DEFAULT_CURRENCY){
            $ratio = $this->dollarRatioManager->getData($currencyToConvert)['ratio'];
        }
        $currency = $this->currencyRepository->find($query->id);

        return new ExtendedCryptoCurrency(
            $currency->id,
            $currency->symbol,
            $currency->name,
            $currency->priceUSD,
            ($currency->priceUSD * $ratio),
            $currencyToConvert ?? "",
            $currency->change1h,
            $currency->change24h,
            $currency->change7d
        );
    }
}
