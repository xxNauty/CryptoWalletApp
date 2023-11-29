<?php

namespace App\Domain\DolarRatio\Service;

use App\Domain\DolarRatio\Model\DolarRatio;

interface DolarRatioManagerInterface
{
    public function getData(string $chosenCurrency): DolarRatio;

    public function updateAll(bool $initial = false): void;

    public function update(string $currency): void;
}
