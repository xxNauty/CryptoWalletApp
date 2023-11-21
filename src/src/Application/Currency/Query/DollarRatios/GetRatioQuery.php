<?php

declare(strict_types=1);

namespace App\Application\Currency\Query\DollarRatios;

use App\Domain\Currency\Model\DollarRatio;
use App\Domain\Shared\Query\QueryInterface;
use Webmozart\Assert\Assert;

class GetRatioQuery implements QueryInterface
{
    public function __construct(
        public string $symbol
    ) {
        Assert::inArray(strtoupper($this->symbol), DollarRatio::SUPPORTED_CURRENCIES, 'This currency is currently not supported');
    }
}
