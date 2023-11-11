<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Application\Currency\Command\CreateCurrencyCommand;
use App\Application\Currency\Command\UpdateCurrencyCommand;
use App\Domain\Shared\ApiPlatform\Resource\ResourceInterface;
use App\Infrastructure\Currency\ApiPlatform\State\Processor\CurrencyCrudProcessor;
use App\Infrastructure\Currency\ApiPlatform\State\Provider\CurrencyCrudProvider;
use App\Infrastructure\Shared\ApiPlatform\Resource\ResourceFactory;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Currency',
    operations: [
        new GetCollection(
            security: 'is_granted("PUBLIC_ACCESS")'
        ),
        new Get(
            security: 'is_granted("PUBLIC_ACCESS")'
        ),
        new Post(
            input: CreateCurrencyCommand::class
        ),
        new Patch(
            input: UpdateCurrencyCommand::class
        ),
        new Delete(),
    ],
    security: 'is_granted("PUBLIC_ACCESS")',
//    security: 'is_granted("ROLE_ADMIN")',
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
