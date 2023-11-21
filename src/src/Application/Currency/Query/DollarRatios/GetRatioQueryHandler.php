<?php

declare(strict_types=1);

namespace App\Application\Currency\Query\DollarRatios;

use App\Domain\Currency\Service\DollarRatioManagerInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;

class GetRatioQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly DollarRatioManagerInterface $dollarRatioManager
    ) {
    }

    public function __invoke(GetRatioQuery $query): array
    {
        return [$query->symbol => $this->dollarRatioManager->getData($query->symbol)];
    }
}
