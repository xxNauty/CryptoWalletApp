<?php

declare(strict_types=1);

namespace App\Application\Currency\Query;

use App\Application\Shared\Query\QueryHandlerInterface;
use App\Domain\Currency\Repository\CurrencyRepositoryInterface;

class FindCurrencyCollectionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository
    ) {
    }

    public function __invoke(FindCurrencyCollectionQuery $query): CurrencyRepositoryInterface
    {
        $currencyRepository = $this->currencyRepository;

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $currencyRepository = $currencyRepository->withPagination($query->page, $query->itemsPerPage);
        }

        return $currencyRepository;
    }
}
