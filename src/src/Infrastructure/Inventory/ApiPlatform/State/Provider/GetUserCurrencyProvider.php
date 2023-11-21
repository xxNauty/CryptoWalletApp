<?php

namespace App\Infrastructure\Inventory\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Inventory\Query\UserInventory\GetUserCurrencyQuery;
use App\Domain\Shared\Query\QueryBusInterface;

class GetUserCurrencyProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->queryBus->ask(new GetUserCurrencyQuery($uriVariables['symbol']));
    }
}
