<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Domain\Shared\ApiPlatform\Resource\ResourceInterface;
use App\Infrastructure\Currency\ApiPlatform\State\Processor\CreateCurrencyProcessor;
use App\Infrastructure\Currency\ApiPlatform\State\Processor\DeleteCurrencyProcessor;
use App\Infrastructure\Currency\ApiPlatform\State\Processor\UpdateCurrencyProcessor;
use App\Infrastructure\Currency\ApiPlatform\State\Provider\CurrencyCrudProvider;
use App\Infrastructure\Currency\ApiPlatform\State\Provider\GetAllowedCurrenciesProvider;
use App\Infrastructure\Currency\ApiPlatform\State\Provider\GetAllowedRemoteCurrenciesProvider;
use App\Infrastructure\Shared\ApiPlatform\Resource\ResourceFactory;

#[ApiResource(
    shortName: 'CryptoCurrency',
    operations: [
        new Get(
            uriTemplate: '/crypto_currencies/get/{id}',
            security: 'is_granted("PUBLIC_ACCESS")',
            provider: CurrencyCrudProvider::class,
        ),
        new Post(
            uriTemplate: '/crypto_currencies/create',
            processor: CreateCurrencyProcessor::class
        ),
        new Patch(
            uriTemplate: '/crypto_currencies/update',
            read: false,
            processor: UpdateCurrencyProcessor::class,
        ),
        new Post( // todo zamienić na delete
            uriTemplate: '/crypto_currencies/delete/{id}',
            processor: DeleteCurrencyProcessor::class,
        ),
        new Get(
            uriTemplate: '/crypto_currencies/available',
            security: 'is_granted("PUBLIC_ACCESS")',
            provider: GetAllowedCurrenciesProvider::class
        ),
        new Get(
            uriTemplate: '/crypto_currencies/available/remote',
            provider: GetAllowedRemoteCurrenciesProvider::class
        ),
    ],
    security: 'is_granted("ROLE_ADMIN")',
)]
class CurrencyResource implements ResourceInterface
{
    #[ApiProperty(identifier: true)]
    public ?int $id = null;

    public ?string $symbol = null;

    public ?string $name = null;

    public ?float $priceUSD = null;

    public ?int $change1h = null;

    public ?int $change24h = null;

    public ?int $change7d = null;

    public static function fromModel(object $model, array $excludedVars = []): object
    {
        $excludedVars[] = 'currency';

        return ResourceFactory::fromModel(self::class, $model, $excludedVars);
    }
}
