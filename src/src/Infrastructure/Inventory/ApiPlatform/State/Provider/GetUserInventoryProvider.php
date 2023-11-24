<?php

namespace App\Infrastructure\Inventory\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Inventory\Query\GetUserInventoryQuery;
use App\Domain\Shared\Query\QueryBusInterface;

class GetUserInventoryProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->queryBus->ask(new GetUserInventoryQuery());
    }
}
