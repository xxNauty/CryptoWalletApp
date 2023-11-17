<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Infrastructure\Currency\ApiPlatform\State\Processor\DolarRatio\UpdateAllRatiosProcessor;
use App\Infrastructure\Currency\ApiPlatform\State\Provider\DolarRatio\GetAllRatiosProvider;
use App\Infrastructure\Currency\ApiPlatform\State\Provider\DolarRatio\GetRatioProvider;

#[ApiResource(
    shortName: 'DollarRatios',
    operations: [
        new Get(
            uriTemplate: '/api/ratios',
            provider: GetAllRatiosProvider::class,
        ),
        new Get(
            uriTemplate: '/api/ratio/{symbol}',
            provider: GetRatioProvider::class,
        ),
        new Post(
            uriTemplate: '/api/ratio/update',
            processor: UpdateAllRatiosProcessor::class
        ),
    ],
    security: 'is_granted("ROLE_ADMIN")'
)]
class DollarRatiosResource
{
}
