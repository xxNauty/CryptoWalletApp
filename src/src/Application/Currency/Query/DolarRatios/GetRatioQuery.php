<?php

declare(strict_types=1);

namespace App\Application\Currency\Query\DolarRatios;

use App\Domain\Currency\Model\DolarRatio;
use App\Domain\Shared\Query\QueryInterface;
use Webmozart\Assert\Assert;

class GetRatioQuery implements QueryInterface
{
    public function __construct(
        public string $symbol
    ) {
        Assert::inArray(strtoupper($this->symbol), DolarRatio::SUPPORTED_CURRENCIES, 'This currency is currently not supported');
    }
}
