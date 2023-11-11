<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Currency\Query\DolarRatios\GetRatioQuery;
use App\Domain\Shared\Query\QueryBusInterface;

class GetRatioProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->queryBus->ask(new GetRatioQuery(strtoupper($uriVariables['symbol'])));
    }
}
