<?php

declare(strict_types=1);

namespace App\Application\DolarRatio\Query;

use App\Domain\DolarRatio\Model\DolarRatio;
use App\Domain\DolarRatio\Service\DolarRatioManagerInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;

readonly class GetRatioQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DolarRatioManagerInterface $dollarRatioManager,
    ) {
    }

    public function __invoke(GetRatioQuery $query): DolarRatio
    {
        return $this->dollarRatioManager->getData($query->symbol);
    }
}
