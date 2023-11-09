<?php

declare(strict_types=1);


namespace App\Application\Currency\Query\DolarRatios;

use App\Domain\Currency\Model\DolarRatios\USDtoPLN;
use App\Domain\Currency\Service\UpdateDolarRatioServiceInterface;
use App\Domain\Shared\Query\QueryHandlerInterface;

class GetRatioQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly UpdateDolarRatioServiceInterface $dolarRatioService
    )
    {
    }

    public function __invoke(GetRatioQuery $query): array
    {
        switch ($query->symbol){
            case 'PLN':
                $currency = USDtoPLN::getInstance();
                $this->dolarRatioService->update('PLN');
                return ['PLN: ', [$currency->ratio, $currency->lastUpdate->format('Y.m.d|H:i:s')]];
        }

        return [];
    }
}