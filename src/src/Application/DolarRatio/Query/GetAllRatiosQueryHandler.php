<?php

declare(strict_types=1);

namespace App\Application\DolarRatio\Query;

use App\Domain\DolarRatio\Service\DolarRatioManagerInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;

readonly class GetAllRatiosQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DolarRatioManagerInterface $dolarRatioManager
    ) {
    }

    public function __invoke(GetAllRatiosQuery $query): array
    {
        return [
            $this->dolarRatioManager->getData('PLN'),
            $this->dolarRatioManager->getData('EUR'),
            $this->dolarRatioManager->getData('GBP'),
            $this->dolarRatioManager->getData('CHF'),
        ];
    }
}
