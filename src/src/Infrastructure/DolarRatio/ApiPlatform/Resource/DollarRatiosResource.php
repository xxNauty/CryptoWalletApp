<?php

declare(strict_types=1);

namespace App\Infrastructure\DolarRatio\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Domain\Shared\ApiPlatform\Resource\ResourceInterface;
use App\Infrastructure\DolarRatio\ApiPlatform\State\Processor\UpdateAllRatiosProcessor;
use App\Infrastructure\DolarRatio\ApiPlatform\State\Provider\GetAllRatiosProvider;
use App\Infrastructure\DolarRatio\ApiPlatform\State\Provider\GetRatioProvider;
use App\Infrastructure\Shared\ApiPlatform\Resource\ResourceFactory;

#[ApiResource(
    shortName: 'DollarRatios',
    operations: [
        new Get(
            uriTemplate: '/ratios',
            provider: GetAllRatiosProvider::class,
        ),
        new Get(
            uriTemplate: '/ratio/{symbol}',
            provider: GetRatioProvider::class,
        ),
        new Post(
            uriTemplate: '/ratio/update',
            security: 'is_granted("ROLE_ADMIN")',
            processor: UpdateAllRatiosProcessor::class
        ),
    ],
    security: 'is_granted("PUBLIC_ACCESS")'
)]
class DollarRatiosResource implements ResourceInterface
{
    public ?string $currencyTo;

    public ?float $ratio;

    public ?\DateTimeImmutable $lastUpdate;

    public static function fromModel(object $model, array $excludedVars = []): object
    {
        return ResourceFactory::fromModel(self::class, $model, $excludedVars);
    }
}
