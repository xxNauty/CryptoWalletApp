<?php

declare(strict_types=1);

namespace App\Domain\Currency\Service;

interface UpdateDollarRatioServiceInterface
{
    public function update(string $currency): float;
}
