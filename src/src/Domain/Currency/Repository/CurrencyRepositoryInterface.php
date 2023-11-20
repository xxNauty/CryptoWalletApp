<?php

declare(strict_types=1);

namespace App\Domain\Currency\Repository;

use App\Domain\Currency\Model\CryptoCurrency;
use App\Domain\Shared\Repository\RepositoryInterface;

interface CurrencyRepositoryInterface extends RepositoryInterface
{
    public function save(CryptoCurrency $currency): void;

    public function remove(CryptoCurrency $currency): void;

    public function find(int $id): ?CryptoCurrency;

    public function getAllowedCurrencies(): ?array;
}
