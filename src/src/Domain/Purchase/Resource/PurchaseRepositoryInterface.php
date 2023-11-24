<?php

namespace App\Domain\Purchase\Resource;

use App\Domain\Purchase\Model\Purchase;

interface PurchaseRepositoryInterface
{
    public function save(Purchase $purchase): void;

    public function remove(Purchase $purchase): void;

    public function find(int $id): ?Purchase;
}