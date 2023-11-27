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
            ['PLN: ' => $this->dolarRatioManager->getData('PLN')],
            ['EUR: ' => $this->dolarRatioManager->getData('EUR')],
            ['GBP: ' => $this->dolarRatioManager->getData('GBP')],
            ['CHF: ' => $this->dolarRatioManager->getData('CHF')],
        ];
    }
}
