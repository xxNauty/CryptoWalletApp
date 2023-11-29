<?php

namespace App\Domain\Purchase\ValueObject;

class InventoryPart
{
    public function __construct(
        public string $symbol,
        public float $amount
    ){}
}