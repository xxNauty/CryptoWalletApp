<?php

declare(strict_types=1);

namespace App\Infrastructure\Inventory\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use App\Application\Inventory\Command\UpdateUserInventoryCommand;
use App\Domain\Shared\ApiPlatform\Resource\ResourceInterface;
use App\Infrastructure\Inventory\ApiPlatform\State\Processor\UpdateUserInventoryProcessor;
use App\Infrastructure\Inventory\ApiPlatform\State\Provider\GetUserCurrencyProvider;
use App\Infrastructure\Inventory\ApiPlatform\State\Provider\GetUserInventoryProvider;
use App\Infrastructure\Shared\ApiPlatform\Resource\ResourceFactory;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Inventory',
    operations: [
        new Get(
            uriTemplate: '/inventories/get',
            provider: GetUserInventoryProvider::class,
        ),
        new Get(
            uriTemplate: '/inventories/get/{symbol}',
            uriVariables: 'symbol',
            provider: GetUserCurrencyProvider::class
        ),
        new Put(
            uriTemplate: 'inventories/update',
            input: UpdateUserInventoryCommand::class,
            processor: UpdateUserInventoryProcessor::class
        ),
    ],
    security: 'is_granted("IS_AUTHENTICATED_FULLY")',
)]
class InventoryResource implements ResourceInterface
{
    #[ApiProperty(writable: false, identifier: true)]
    public ?int $id = null;

    #[Groups(['user.read', 'inventory.read'])]
    public ?float $totalInventoryValue = null;

    #[Groups(['user.read', 'inventory.read'])]
    public ?iterable $content = null;

    public static function fromModel(object $model, array $excludedVars = []): object
    {
        $excludedVars[] = 'inventory';

        return ResourceFactory::fromModel(self::class, $model, $excludedVars);
    }
}
