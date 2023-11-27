<?php

namespace App\Domain\Purchase\Model;

use App\Domain\Inventory\Model\Inventory;
use App\Domain\Shared\Model\ModelInterface;
use App\Infrastructure\Purchase\ApiPlatform\Resource\PurchaseResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'purchase')]
class Purchase implements ModelInterface
{
    public const RESOURCE = PurchaseResource::class;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    public int $id;

    #[ORM\ManyToOne(targetEntity: Inventory::class, inversedBy: 'content')]
    private Inventory $inventory;

    public function __construct(
        #[ORM\Column(type: Types::STRING)]
        public string $symbol,

        #[ORM\Column(type: Types::FLOAT)]
        public float $amount,

        #[ORM\Column(type: Types::FLOAT)]
        public float $singlePrice,

        #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
        public \DateTimeImmutable $boughtAt,

        #[ORM\Column(type: Types::BOOLEAN)]
        public bool $sold // jeśli true => sprzedaż, jeśli false => kupno
    ) {
    }

    public function getInventory(): Inventory
    {
        return $this->inventory;
    }

    public function setInventory(Inventory $inventory): void
    {
        $this->inventory = $inventory;
    }

    public function getResource(): string
    {
        return self::RESOURCE;
    }
}
