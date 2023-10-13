<?php

namespace App\Domain\Currency\Repository;

use App\Domain\Currency\Model\Currency;
use App\Domain\Shared\Repository\RepositoryInterface;

interface CurrencyRepositoryInterface extends RepositoryInterface
{
    public function save(Currency $currency): void;

    public function remove(Currency $currency): void;

    public function find(int $id): ?Currency;
}