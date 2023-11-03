<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Application\Currency\Query\FindCurrencyCollectionQuery;
use App\Application\Currency\Query\FindCurrencyQuery;
use App\Application\Shared\Query\QueryBusInterface;
use App\Infrastructure\Currency\ApiPlatform\Resource\CurrencyResource;
use App\Infrastructure\Shared\ApiPlatform\State\Paginator;

class CurrencyCrudProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly Pagination $pagination,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!$operation instanceof CollectionOperationInterface) {
            $model = $this->queryBus->ask(new FindCurrencyQuery($uriVariables['id']));

            return null !== $model ? CurrencyResource::fromModel($model) : null;
        }

        $offset = $limit = null;

        if ($this->pagination->isEnabled($operation, $context)) {
            $offset = $this->pagination->getPage($context);
            $limit = $this->pagination->getLimit($operation, $context);
        }

        $models = $this->queryBus->ask(new FindCurrencyCollectionQuery($offset, $limit));

        $resources = [];
        foreach ($models as $model) {
            $resources[] = CurrencyResource::fromModel($model);
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
