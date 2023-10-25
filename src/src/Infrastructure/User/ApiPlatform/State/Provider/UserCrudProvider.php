<?php

declare(strict_types=1);

namespace App\Infrastructure\User\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Application\Shared\Query\QueryBusInterface;
use App\Application\User\Query\FindUserCollectionQuery;
use App\Application\User\Query\FindUserQuery;
use App\Domain\User\Model\User;
use App\Infrastructure\Shared\ApiPlatform\State\Paginator;
use App\Infrastructure\User\ApiPlatform\Resource\UserResource;

class UserCrudProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly Pagination $pagination,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!$operation instanceof CollectionOperationInterface) {
            /** @var User|null $model */
            $model = $this->queryBus->ask(new FindUserQuery($uriVariables['id']));

            return null !== $model ? UserResource::fromModel($model) : null;
        }

        $firstName = $context['filters']['firstName'] ?? null;
        $offset = $limit = null;

        if ($this->pagination->isEnabled($operation, $context)) {
            $offset = $this->pagination->getPage($context);
            $limit = $this->pagination->getLimit($operation, $context);
        }

        $models = $this->queryBus->ask(new FindUserCollectionQuery($firstName, $offset, $limit));

        $resources = [];
        foreach ($models as $model) {
            $resources[] = UserResource::fromModel($model);
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
