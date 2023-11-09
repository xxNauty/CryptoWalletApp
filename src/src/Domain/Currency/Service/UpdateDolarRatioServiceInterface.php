<?php

declare(strict_types=1);


namespace App\Domain\Currency\Service;

interface UpdateDolarRatioServiceInterface
{
    public function update(string $currency): void;
}