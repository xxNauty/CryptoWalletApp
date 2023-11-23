<?php

namespace App\Application\Currency\Query;

use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;

readonly class FindAvailableCurrenciesQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CurrencyRepositoryInterface $currencyRepository
    ) {
    }

    public function __invoke(FindAvailableCurrenciesQuery $query): ?array
    {
        return $this->currencyRepository->getAllowedCurrencies();
    }
}
