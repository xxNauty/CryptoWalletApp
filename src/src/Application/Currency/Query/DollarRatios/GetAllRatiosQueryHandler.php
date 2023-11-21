<?php

declare(strict_types=1);

namespace App\Application\Currency\Query\DollarRatios;

use App\Domain\Currency\Service\DollarRatioManagerInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;

readonly class GetAllRatiosQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DollarRatioManagerInterface $dollarRatioManager
    ) {
    }

    public function __invoke(GetAllRatiosQuery $query): array
    {
        return [
            ['PLN: ' => $this->dollarRatioManager->getData('PLN')],
            ['EUR: ' => $this->dollarRatioManager->getData('EUR')],
            ['GBP: ' => $this->dollarRatioManager->getData('GBP')],
            ['CHF: ' => $this->dollarRatioManager->getData('CHF')],
        ];
    }
}
