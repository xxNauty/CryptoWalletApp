<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\ApiPlatform\State\Provider\DollarRatio;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Currency\Query\DollarRatios\GetRatioQuery;
use App\Domain\Shared\Query\QueryBusInterface;

class GetRatioProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->queryBus->ask(new GetRatioQuery(strtoupper($uriVariables['symbol'])));
    }
}
