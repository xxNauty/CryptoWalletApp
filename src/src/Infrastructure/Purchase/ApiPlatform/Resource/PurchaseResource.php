<?php

namespace App\Infrastructure\Purchase\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Domain\Shared\ApiPlatform\Resource\ResourceInterface;
use App\Infrastructure\Purchase\ApiPlatform\State\Processor\PurchaseProcessor;
use App\Infrastructure\Purchase\ApiPlatform\State\Provider\CompleteInventoryProvider;
use App\Infrastructure\Purchase\ApiPlatform\State\Provider\InventoryPartProvider;
use App\Infrastructure\Shared\ApiPlatform\Resource\ResourceFactory;

#[ApiResource(
    shortName: 'Purchase',
    operations: [
        new Post(
            uriTemplate: '/purchase/action',
            processor: PurchaseProcessor::class
        ),
        new Get(
            uriTemplate: '/inventory',
            provider: CompleteInventoryProvider::class
        ),
        new Get(
            uriTemplate: '/inventory/{symbol}',
            uriVariables: 'symbol',
            provider: InventoryPartProvider::class
        )
    ],
)]
class PurchaseResource implements ResourceInterface
{
    #[ApiProperty(writable: false, identifier: true)]
    public ?int $id = null;

    public ?string $symbol = null;

    public ?float $amount = null;

    public ?float $singlePrice = null;

    public ?\DateTimeImmutable $boughtAt = null;

    public bool $sold = false;

    public static function fromModel(object $model, array $excludedVars = []): object
    {
        $excludedVars[] = 'purchase';

        return ResourceFactory::fromModel(self::class, $model, $excludedVars);
    }
}
