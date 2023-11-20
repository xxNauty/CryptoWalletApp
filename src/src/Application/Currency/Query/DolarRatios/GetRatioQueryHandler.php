<?php

declare(strict_types=1);

namespace App\Application\Currency\Query\DolarRatios;

use App\Domain\Currency\Service\DolarRatioManagerInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;

class GetRatioQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly DolarRatioManagerInterface $dolarRatioManager
    ) {
    }

    public function __invoke(GetRatioQuery $query): array
    {
        return [$query->symbol => $this->dolarRatioManager->getData($query->symbol)];
    }
}
