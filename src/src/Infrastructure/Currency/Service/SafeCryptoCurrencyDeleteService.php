<?php

namespace App\Infrastructure\Currency\Service;

use App\Domain\Currency\Model\CryptoCurrency;
use App\Domain\Currency\Service\SafeCryptoCurrencyDeleteServiceInterface;

readonly class SafeCryptoCurrencyDeleteService implements SafeCryptoCurrencyDeleteServiceInterface
{
    public function __construct()
    {
    }

    public function canBeDeleted(CryptoCurrency $currency): bool
    {
        return true;
    }
}
