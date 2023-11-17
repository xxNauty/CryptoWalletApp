<?php

declare(strict_types=1);

namespace App\Domain\Currency\Service;

interface DolarRatioManagerInterface
{
    public function getData(string $chosenCurrency): array;

    public function updateAll(bool $initial = false): void;

    public function update(string $currency): void;
}
