<?php

declare(strict_types=1);

namespace App\Application\Inventory\Query\UserInventory;

use App\Domain\Inventory\Model\Inventory;
use App\Domain\Shared\Query\QueryHandlerInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Service\UserSecurityServiceInterface;
use App\Infrastructure\Inventory\ApiPlatform\Resource\InventoryResource;
use App\Infrastructure\Shared\ApiPlatform\Resource\ResourceFactory;

readonly class GetUserInventoryQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserSecurityServiceInterface $securityService
    ) {
    }

    public function __invoke(GetUserInventoryQuery $query)
    {
        $model = $this->securityService->getUser()->inventory;
//        return $model->inventory;
        return InventoryResource::fromModel($model);
    }
}
