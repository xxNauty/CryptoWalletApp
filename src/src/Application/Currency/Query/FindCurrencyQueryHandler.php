<?php

declare(strict_types=1);

namespace App\Application\Currency\Query;

use App\Domain\Currency\Model\CryptoCurrency;
use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;

readonly class FindCurrencyQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CurrencyRepositoryInterface $currencyRepository,
    ) {
    }

    public function __invoke(FindCurrencyQuery $query): CryptoCurrency
    {
        return $this->currencyRepository->findBy(['symbol' => $query->id]);
    }
}
