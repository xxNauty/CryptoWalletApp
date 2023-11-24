<?php

namespace App\Infrastructure\Inventory\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Inventory\Query\FindInventoryQuery;
use App\Application\Inventory\Query\UserInventory\GetUserInventoryQuery;
use App\Domain\Shared\Query\QueryBusInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;
use App\Infrastructure\Inventory\ApiPlatform\Resource\InventoryResource;
use App\Infrastructure\Shared\ApiPlatform\Resource\ResourceFactory;

class GetUserInventoryProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly UserSecurityServiceInterface $securityService
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $user = $this->securityService->getUser();

        return InventoryResource::fromModel($this->queryBus->ask(new FindInventoryQuery($user->id)));
    }
}
