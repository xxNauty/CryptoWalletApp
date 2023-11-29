<?php

namespace App\Infrastructure\Purchase\Service;

use App\Domain\Purchase\Model\Purchase;
use App\Domain\Purchase\Service\InventoryValueServiceInterface;
use App\Domain\User\Model\User;

class InventoryValueService implements InventoryValueServiceInterface
{
    public function getTotalValue(User $user): float
    {
        $inventory = $user->inventory;
        $value = 0;

        foreach ($inventory as $item) {
            /** @var Purchase $item */
            $singleValue = $item->amount * $item->singlePrice;
            $value += $singleValue;
        }

        return $value;
    }

    public function getValueOfCurrency(User $user, string $symbol): float
    {
        $inventory = $user->inventory;
        $value = 0;

        foreach ($inventory as $item) {
            /** @var Purchase $item */
            if ($item->symbol == $symbol) {
                $singleValue = $item->amount * $item->singlePrice;
                $value += $singleValue;
            }
        }

        return $value;
    }

    public function getCountOfCurrency(User $user, string $symbol): float
    {
        $inventory = $user->inventory;
        $count = 0;

        foreach ($inventory as $item) {
            /** @var Purchase $item */
            if ($item->symbol == $symbol) {
                $count += $item->amount;
            }
        }

        return $count;
    }
}
