<?php

namespace App\Domain\DolarRatio\Service;

interface DolarRatioManagerInterface
{
    public function getData(string $chosenCurrency): array;

    public function updateAll(bool $initial = false): void;

    public function update(string $currency): void;
}