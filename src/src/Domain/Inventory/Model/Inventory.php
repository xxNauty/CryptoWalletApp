<?php

declare(strict_types=1);

namespace App\Domain\Inventory\Model;

use App\Domain\Purchase\Model\Purchase;
use App\Domain\Shared\Model\ModelInterface;
use App\Domain\User\Model\User;
use App\Infrastructure\Inventory\ApiPlatform\Resource\InventoryResource;
use App\Infrastructure\Shared\Trait\SoftDeletableTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity]
#[ORM\Table(name: 'inventory')]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class Inventory implements ModelInterface
{
    use SoftDeletableTrait;

    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    public int $id;

    #[ORM\Column(type: Types::FLOAT, precision: 2)]
    public float $totalInventoryValue;

    #[ORM\OneToMany(mappedBy: 'inventory', targetEntity: Purchase::class)]
    public ?iterable $content = null;

    public function __construct()
    {
        $this->totalInventoryValue = 0;
    }

    public function getResource(): string
    {
        return InventoryResource::class;
    }
}
