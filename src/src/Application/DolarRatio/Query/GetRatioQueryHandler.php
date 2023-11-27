<?php

declare(strict_types=1);

namespace App\Application\DolarRatio\Query;

use App\Domain\DolarRatio\Service\DolarRatioManagerInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;

class GetRatioQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly DolarRatioManagerInterface $dollarRatioManager,
    ) {
    }

    public function __invoke(GetRatioQuery $query): array
    {
        return [$query->symbol => $this->dollarRatioManager->getData($query->symbol)];
    }
}
