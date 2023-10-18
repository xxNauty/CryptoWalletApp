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
use App\Domain\Currency\Model\Currency;
use App\Infrastructure\Currency\ApiPlatform\State\Processor\CurrencyCrudProcessor;
use App\Infrastructure\Currency\ApiPlatform\State\Provider\CurrencyCrudProvider;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Currency',
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    security: 'is_granted("PUBLIC_ACCESS")',
    provider: CurrencyCrudProvider::class,
    processor: CurrencyCrudProcessor::class,
)]
class CurrencyResource
{
    public function __construct(
        #[ApiProperty(writable: false, identifier: true)]
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

    public static function fromModel(Currency $currency): self
    {
        return new self(
            $currency->id,
            $currency->symbol,
            $currency->name,
            $currency->priceUSD,
            $currency->change1h,
            $currency->change24h,
            $currency->change7d
        );
    }
}
