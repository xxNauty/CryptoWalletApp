<?php

namespace App\Domain\Currency\Model;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity]
#[ORM\Table(name: 'currency')]
class Currency
{
    public static float $USDtoPLN = 4.32;
    public static DateTimeImmutable $lastUpdateOfUSDtoPLNRatio;

    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    public readonly int $id;

    public function __construct(
        #[ORM\Column(type: Types::STRING, length: 3)]
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
    ){
        Assert::inArray($this->change1h, [-1, 0, 1]);
        Assert::inArray($this->change24h, [-1, 0, 1]);
        Assert::inArray($this->change7d, [-1, 0, 1]);
        // -1 => spadek, 0 => bez zmian, 1 => wzrost
    }
}