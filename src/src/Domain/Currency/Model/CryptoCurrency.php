<?php

declare(strict_types=1);

namespace App\Domain\Currency\Model;

use App\Domain\Shared\Model\ModelInterface;
use App\Infrastructure\Currency\ApiPlatform\Resource\CurrencyResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity]
#[ORM\Table(name: 'currency')]
class CryptoCurrency implements ModelInterface
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: Types::INTEGER)]
        public int $id,

        #[ORM\Column(type: Types::STRING, length: 4, unique: true)]
        public string $symbol,

        #[ORM\Column(type: Types::STRING)]
        public string $name,

        #[ORM\Column(type: Types::FLOAT, precision: 2)]
        public float $priceUSD,

        #[ORM\Column(type: Types::INTEGER)]
        public int $change1h,

        #[ORM\Column(type: Types::INTEGER)]
        public int $change24h,

        #[ORM\Column(type: Types::INTEGER)]
        public int $change7d,
    ) {
        Assert::nullOrInArray($this->change1h, [-1, 0, 1]);
        Assert::nullOrInArray($this->change24h, [-1, 0, 1]);
        Assert::nullOrInArray($this->change7d, [-1, 0, 1]);
        // -1 => spadek, 0 => bez zmian, 1 => wzrost
    }

    public function getResource(): string
    {
        return CurrencyResource::class;
    }
}
