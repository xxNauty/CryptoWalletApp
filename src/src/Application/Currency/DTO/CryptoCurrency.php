<?php

namespace App\Application\Currency\DTO;

class CryptoCurrency
{
    public function __construct(
        public int $id,
        public string $symbol,
        public string $name,
        public float $priceUSD,
        public int $change1h,
        public int $change24h,
        public int $change7d,
    ) {
    }
}
