<?php

namespace App\Domain\Purchase\Resource;

use App\Domain\Purchase\Model\Purchase;
use App\Domain\User\Model\User;

interface PurchaseRepositoryInterface
{
    public function save(Purchase $purchase): void;

    public function remove(Purchase $purchase): void;

    public function find(int $id): ?Purchase;

    public function getValueOfCurrency(User $user, string $symbol): float;

    public function getUsersCurrencies(User $user): array;

    public function findUsedCurrencies(): ?array;
}
