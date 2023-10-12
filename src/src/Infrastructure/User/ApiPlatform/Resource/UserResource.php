<?php

declare(strict_types=1);

namespace App\Infrastructure\User\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Domain\User\Model\User;
use App\Infrastructure\User\ApiPlatform\OpenApi\UserFilter;
use App\Infrastructure\User\ApiPlatform\State\Processor\UserCrudProcessor;
use App\Infrastructure\User\ApiPlatform\State\Provider\UserCrudProvider;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'User',
    operations: [
        new GetCollection(filters: [UserFilter::class]),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    provider: UserCrudProvider::class,
    processor: UserCrudProcessor::class,
)]
final class UserResource
{
    public function __construct(
        #[ApiProperty(writable: false, identifier: true)]
        public ?int $id = null,

        #[Assert\NotNull]
        #[Assert\Email]
        #[Assert\Length(min: 5, max: 100)]
        public ?string $email = null,

        #[Assert\NotNull]
        #[Assert\Length(min: 1, max: 50)]
        public ?string $firstName = null,

        #[Assert\NotNull]
        #[Assert\Length(min: 1, max: 50)]
        public ?string $lastName = null,

        #[Assert\NotNull]
        #[Assert\Length(min: 1, max: 50)]
        public ?string $password = null,
    ) {}

    public static function fromModel(User $user): self
    {
        return new self(
            $user->id,
            $user->email,
            $user->firstName,
            $user->lastName
        );
    }
}
