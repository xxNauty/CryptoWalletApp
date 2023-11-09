<?php

declare(strict_types=1);

namespace App\Domain\Currency\Service;

use App\Domain\Currency\Model\Currency;

interface CryptoCurrencyDataDownloadServiceInterface
{
    public function create(int $identifier): Currency;

    public function update(Currency $currency): Currency;
}