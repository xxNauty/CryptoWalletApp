<?php

namespace App\Infrastructure\Purchase\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use App\Domain\Shared\ApiPlatform\Resource\ResourceInterface;
use App\Infrastructure\Shared\ApiPlatform\Resource\ResourceFactory;
use Symfony\Component\Serializer\Annotation\Groups;

class PurchaseResource implements ResourceInterface
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        public ?int $id = null,

        #[Groups(['user.read'])]
        public ?string $symbol = null,

        #[Groups(['user.read'])]
        public ?float $amount = null,

        #[Groups(['user.read'])]
        public ?float $singlePrice = null,

        #[Groups(['user.read'])]
        public ?\DateTimeImmutable $boughtAt = null,

        #[Groups(['user.read'])]
        public ?bool $sold = null,
    ) {
    }

    public static function fromModel(object $model, array $excludedVars = []): object
    {
        $excludedVars[] = 'purchase';

        return ResourceFactory::fromModel(self::class, $model, $excludedVars);
    }
}
