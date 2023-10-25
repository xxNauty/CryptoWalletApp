<?php

declare(strict_types=1);

namespace App\Domain\Inventory\Model;

use App\Domain\Shared\Model\ModelInterface;
use App\Domain\User\Model\User;
use App\Infrastructure\Inventory\ApiPlatform\Resource\InventoryResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'inventory')]
class Inventory implements ModelInterface
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    public readonly int $id;

    #[ORM\Column(type: Types::FLOAT, precision: 2)]
    public float $totalInventoryValue;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    public ?array $content = null;

    public function __construct(
        #[ORM\OneToOne(mappedBy: 'inventory', targetEntity: User::class)]
        public User $owner,
    ) {
        $this->totalInventoryValue = 0;
    }

    public function getResource(): string
    {
        return InventoryResource::class;
    }
}
