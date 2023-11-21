<?php

namespace App\Application\Currency\DTO;

class ExtendedCryptoCurrency
{
    public function __construct(
        public int $id,
        public string $symbol,
        public string $name,
        public float $priceUSD,
        public float $priceConverted,
        public string $currencyToConvert,
        public int $change1h,
        public int $change24h,
        public int $change7d,
    ){
    }
}