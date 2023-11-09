<?php

declare(strict_types=1);


namespace App\Application\Currency\Query\DolarRatios;

use App\Domain\Shared\Query\QueryInterface;

class GetRatioQuery implements QueryInterface
{
    public function __construct(
        public string $symbol
    )
    {
    }
}