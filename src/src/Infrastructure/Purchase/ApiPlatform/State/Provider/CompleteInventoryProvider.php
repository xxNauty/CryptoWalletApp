<?php

namespace App\Infrastructure\Purchase\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Purchase\Query\GetInventoryQuery;
use App\Domain\Shared\Query\QueryBusInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;
use App\Infrastructure\Purchase\ApiPlatform\Resource\PurchaseResource;

readonly class CompleteInventoryProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private UserSecurityServiceInterface $securityService
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $user = $this->securityService->getUser();

        $models = $this->queryBus->ask(
            new GetInventoryQuery(
                $user
            )
        );
        $resources = [];

        foreach ($models as $model) {
            $resources[] = PurchaseResource::fromModel($model);
        }

        return $resources;
    }
}
