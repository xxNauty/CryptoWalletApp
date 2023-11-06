<?php

declare(strict_types=1);

namespace App\Application\Currency\Query;

use App\Domain\Currency\Model\Currency;
use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;

class FindCurrencyQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository
    ) {
    }

    public function __invoke(FindCurrencyQuery $query): ?Currency
    {
        return $this->currencyRepository->find($query->id);
    }
}
