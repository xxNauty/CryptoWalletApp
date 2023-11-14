<?php

declare(strict_types=1);

namespace App\Application\Currency\Query\DolarRatios;

use App\Domain\Currency\Model\DolarRatios\USDtoCHF;
use App\Domain\Currency\Model\DolarRatios\USDtoEUR;
use App\Domain\Currency\Model\DolarRatios\USDtoGBP;
use App\Domain\Currency\Model\DolarRatios\USDtoPLN;
use App\Domain\Currency\Service\DolarRatioManagerInterface;
use App\Domain\Currency\Service\UpdateDolarRatioServiceInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;
use App\Infrastructure\Currency\Service\DolarRatioManager;

class GetAllRatiosQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly DolarRatioManagerInterface $dolarRatioManager
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
