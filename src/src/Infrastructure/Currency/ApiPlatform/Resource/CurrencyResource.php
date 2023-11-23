<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Application\Currency\Command\CreateCurrencyCommand;
use App\Application\Currency\Command\UpdateCurrencyCommand;
use App\Domain\Shared\ApiPlatform\Resource\ResourceInterface;
use App\Infrastructure\Currency\ApiPlatform\State\Processor\CurrencyCrudProcessor;
use App\Infrastructure\Currency\ApiPlatform\State\Provider\CryptoCurrency\CurrencyCrudProvider;
use App\Infrastructure\Currency\ApiPlatform\State\Provider\CryptoCurrency\GetAllowedCurrenciesProvider;
use App\Infrastructure\Currency\ApiPlatform\State\Provider\CryptoCurrency\GetAllowedRemoteCurrenciesProvider;
use App\Infrastructure\Shared\ApiPlatform\Resource\ResourceFactory;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'CryptoCurrency',
    operations: [
        new Get(
            security: 'is_granted("PUBLIC_ACCESS")'
        ),
        new Post(
            input: CreateCurrencyCommand::class,
        ),
        new Patch(
            input: UpdateCurrencyCommand::class
        ),
        new Delete(),
        new Get(
            uriTemplate: '/crypto_currencies/allowed',
            security: 'is_granted("PUBLIC_ACCESS")',
            provider: GetAllowedCurrenciesProvider::class
        ),
        new Get(
            uriTemplate: '/crypto_currencies/allowed/remote',
            provider: GetAllowedRemoteCurrenciesProvider::class
        ),
    ],
    security: 'is_granted("ROLE_ADMIN")',
    provider: CurrencyCrudProvider::class,
    processor: CurrencyCrudProcessor::class,
)]
class CurrencyResource implements ResourceInterface
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        public ?int $id = null,

        #[Assert\Length(exactly: 3)]
        public ?string $symbol = null,

        public ?string $name = null,

        public ?float $priceUSD = null,

        public ?int $change1h = null,

        public ?int $change24h = null,

        public ?int $change7d = null,
    ) {
    }

    public static function fromModel(object $model, array $excludedVars = []): object
    {
        return ResourceFactory::fromModel(self::class, $model);
    }
}
