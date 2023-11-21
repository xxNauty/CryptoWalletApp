<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Infrastructure\Currency\ApiPlatform\State\Processor\DollarRatio\UpdateAllRatiosProcessor;
use App\Infrastructure\Currency\ApiPlatform\State\Provider\DollarRatio\GetAllRatiosProvider;
use App\Infrastructure\Currency\ApiPlatform\State\Provider\DollarRatio\GetRatioProvider;

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
class DollarRatiosResource
{
}
