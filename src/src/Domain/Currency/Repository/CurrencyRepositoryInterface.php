<?php

declare(strict_types=1);

namespace App\Domain\Currency\Repository;

use App\Domain\Currency\Model\CryptoCurrency;

interface CurrencyRepositoryInterface
{
    public function save(CryptoCurrency $currency): void;

    public function remove(CryptoCurrency $currency): void;

    public function find(int $id): ?CryptoCurrency;

    public function getAvailableCurrencies(): ?array;

    public function getAvailableCurrenciesNames(): ?array;

    public function findBy(array $params): ?CryptoCurrency;
}
