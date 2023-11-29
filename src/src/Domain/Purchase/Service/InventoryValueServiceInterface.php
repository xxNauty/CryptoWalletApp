<?php

namespace App\Domain\Purchase\Service;

use App\Domain\User\Model\User;

interface InventoryValueServiceInterface
{
    public function getTotalValue(User $user): float;

    public function getValueOfCurrency(User $user, string $symbol): float;

    public function getCountOfCurrency(User $user, string $symbol): float;
}
