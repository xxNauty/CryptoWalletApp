<?php

namespace App\Infrastructure\Purchase\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Purchase\Query\GetCurrencyAmountQuery;
use App\Domain\Shared\Query\QueryBusInterface;
use App\Infrastructure\Purchase\ApiPlatform\Resource\PurchaseResource;

readonly class InventoryPartProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $model = $this->queryBus->ask(new GetCurrencyAmountQuery($uriVariables['symbol']));

        return PurchaseResource::fromModel($model);
    }
}
