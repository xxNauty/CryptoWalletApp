<?php

declare(strict_types=1);

namespace App\Infrastructure\DolarRatio\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\DolarRatio\Query\GetAllRatiosQuery;
use App\Domain\Shared\Query\QueryBusInterface;
use App\Infrastructure\DolarRatio\ApiPlatform\Resource\DollarRatiosResource;

readonly class GetAllRatiosProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $resources = [];
        $models = $this->queryBus->ask(new GetAllRatiosQuery());

        foreach ($models as $model) {
            $resources[] = DollarRatiosResource::fromModel($model);
        }

        return $resources;
    }
}
