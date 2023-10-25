<?php

declare(strict_types=1);

namespace App\Infrastructure\Inventory\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Application\Inventory\Query\FindInventoryCollectionQuery;
use App\Application\Inventory\Query\FindInventoryQuery;
use App\Application\Shared\Query\QueryBusInterface;
use App\Infrastructure\Inventory\ApiPlatform\Resource\InventoryResource;
use App\Infrastructure\Shared\ApiPlatform\State\Paginator;

class InventoryCrudProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly Pagination $pagination,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!$operation instanceof CollectionOperationInterface) {
            $model = $this->queryBus->ask(new FindInventoryQuery($uriVariables['id']));

            return null !== $model ? InventoryResource::fromModel($model) : null;
        }

        $offset = $limit = null;

        if ($this->pagination->isEnabled($operation, $context)) {
            $offset = $this->pagination->getPage($context);
            $limit = $this->pagination->getLimit($operation, $context);
        }

        $models = $this->queryBus->ask(new FindInventoryCollectionQuery($offset, $limit));

        $resources = [];
        foreach ($models as $model) {
            $resources[] = InventoryResource::fromModel($model);
        }

        if (null !== $paginator = $models->paginator()) {
            $resources = new Paginator(
                $resources,
                (float) $paginator->getCurrentPage(),
                (float) $paginator->getItemsPerPage(),
                (float) $paginator->getLastPage(),
                (float) $paginator->getTotalItems(),
            );
        }

        return $resources;
    }
}
