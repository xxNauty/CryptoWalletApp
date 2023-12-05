<?php

namespace App\Infrastructure\User\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Application\User\Query\FindUserCollectionQuery;
use App\Domain\Shared\Query\QueryBusInterface;
use App\Infrastructure\Shared\ApiPlatform\State\Paginator;
use App\Infrastructure\User\ApiPlatform\Resource\UserResource;

readonly class GetUserCollectionProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $models = $this->queryBus->ask(
          new FindUserCollectionQuery(
            $uriVariables['page'], 
            $uriVariables['itemsPerPage']
          )
        );
        $resources = [];

        foreach ($models as $model) {
            $resources[] = UserResource::fromModel($model);
        }
        return $resources;
    }
}
