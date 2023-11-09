<?php

declare(strict_types=1);

namespace App\Application\Currency\Query\DolarRatios;

use App\Domain\Currency\Model\DolarRatios\USDtoCHF;
use App\Domain\Currency\Model\DolarRatios\USDtoEUR;
use App\Domain\Currency\Model\DolarRatios\USDtoGBP;
use App\Domain\Currency\Model\DolarRatios\USDtoPLN;
use App\Domain\Currency\Service\UpdateDolarRatioServiceInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;

class GetAllRatiosQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly UpdateDolarRatioServiceInterface $dolarRatioService
    )
    {
    }

    public function __invoke(GetAllRatiosQuery $query): array
    {
        $pln = USDtoPLN::getInstance();
        $this->dolarRatioService->update('PLN');

        $eur = USDtoEUR::getInstance();
        $eur->updateValue(0.93);

        $gbp = USDtoGBP::getInstance();
        $gbp->updateValue(0.81);

        $chf = USDtoCHF::getInstance();
        $chf->updateValue(0.90);

        return [
            "PLN: ", [$pln->ratio, $pln->lastUpdate->format('Y.m.d|H:i:s')],
            "EUR: ", [$eur->ratio, $eur->lastUpdate->format('Y.m.d|H:i:s')],
            "GBP: ", [$gbp->ratio, $gbp->lastUpdate->format('Y.m.d|H:i:s')],
            "CHF: ", [$chf->ratio, $chf->lastUpdate->format('Y.m.d|H:i:s')],
        ];
    }
}