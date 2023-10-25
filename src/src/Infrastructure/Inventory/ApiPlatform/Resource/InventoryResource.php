<?php

declare(strict_types=1);

namespace App\Infrastructure\Inventory\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Infrastructure\Inventory\ApiPlatform\State\Processor\InventoryCrudProcessor;
use App\Infrastructure\Inventory\ApiPlatform\State\Provider\InventoryCrudProvider;
use App\Infrastructure\Shared\ApiPlatform\Resource\ResourceFactory;
use App\Infrastructure\Shared\ApiPlatform\Resource\ResourceInterface;
use App\Infrastructure\User\ApiPlatform\Resource\UserResource;

#[ApiResource(
    shortName: 'Inventory',
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    security: 'is_granted("PUBLIC_ACCESS")',
    provider: InventoryCrudProvider::class,
    processor: InventoryCrudProcessor::class,
)]
class InventoryResource implements ResourceInterface
{
    public function __construct(
        #[ApiProperty(writable: false, identifier: true)]
        public ?int $id = null,

        public ?UserResource $user = null,

        public ?float $totalInventoryValue = null,

        public ?array $content = null,
    ) {
    }

    public static function fromModel(object $model, array $excludedVars = []): object
    {
        return ResourceFactory::fromModel(self::class, $model);
    }
}
