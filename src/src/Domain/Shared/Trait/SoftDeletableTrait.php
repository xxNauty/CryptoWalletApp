<?php

declare(strict_types=1);

namespace App\Domain\Shared\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SoftDeletableTrait
{
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    protected ?\DateTimeImmutable $deletedAt = null;

    public function getDeleted(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }
}