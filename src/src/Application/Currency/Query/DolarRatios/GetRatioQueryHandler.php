<?php

declare(strict_types=1);

namespace App\Application\Currency\Query\DolarRatios;

use App\Domain\Currency\Model\DolarRatios\USDtoPLN;
use App\Domain\Currency\Service\UpdateDolarRatioServiceInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;
use App\Infrastructure\Currency\Service\DolarRatioManager;

class GetRatioQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly DolarRatioManager $dolarRatioManager
    ) {
    }

    public function __invoke(GetRatioQuery $query): array
    {
        return [$query->symbol => $this->dolarRatioManager->getData($query->symbol)];
    }
}
