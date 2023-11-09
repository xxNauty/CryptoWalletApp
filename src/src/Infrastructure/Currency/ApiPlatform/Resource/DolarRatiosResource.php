<?php

declare(strict_types=1);


namespace App\Infrastructure\Currency\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Infrastructure\Currency\ApiPlatform\State\Provider\GetAllRatiosProvider;
use App\Infrastructure\Currency\ApiPlatform\State\Provider\GetRatioProvider;

#[ApiResource(
    shortName: 'DolarRatios',
    operations: [
        new Get(
            uriTemplate: '/api/ratios',
            provider: GetAllRatiosProvider::class,
        ),
        new Get(
            uriTemplate: '/api/ratio/{symbol}',
            provider: GetRatioProvider::class,
        )
    ],
    security: 'is_granted("PUBLIC_ACCESS")'
)]
class DolarRatiosResource
{

}