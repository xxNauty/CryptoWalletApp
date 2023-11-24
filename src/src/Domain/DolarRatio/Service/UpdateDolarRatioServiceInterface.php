<?php

namespace App\Domain\DolarRatio\Service;

interface UpdateDolarRatioServiceInterface
{
    public function update(string $currency): float;
}