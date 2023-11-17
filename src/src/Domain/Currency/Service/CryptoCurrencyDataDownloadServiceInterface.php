<?php

declare(strict_types=1);

namespace App\Domain\Currency\Service;

use App\Domain\Currency\Model\CryptoCurrency;

interface CryptoCurrencyDataDownloadServiceInterface
{
    public function create(int $identifier): CryptoCurrency;

    public function update(CryptoCurrency $currency): CryptoCurrency;
}
