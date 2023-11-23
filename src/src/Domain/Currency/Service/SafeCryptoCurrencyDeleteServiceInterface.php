<?php

namespace App\Domain\Currency\Service;

use App\Domain\Currency\Model\CryptoCurrency;

interface SafeCryptoCurrencyDeleteServiceInterface
{
    public function canBeDeleted(CryptoCurrency $currency): bool;
}
