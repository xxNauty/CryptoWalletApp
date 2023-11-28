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
use App\Domain\Shared\ApiPlatform\Resource\ResourceInterface;
use App\Infrastructure\Shared\ApiPlatform\Resource\ResourceFactory;
use App\Infrastructure\User\ApiPlatform\State\Processor\CreateUserProcessor;
use App\Infrastructure\User\ApiPlatform\State\Processor\DeleteUserProcessor;
use App\Infrastructure\User\ApiPlatform\State\Processor\UpdateUserProcessor;
use App\Infrastructure\User\ApiPlatform\State\Provider\GetUserCollectionProvider;
use App\Infrastructure\User\ApiPlatform\State\Provider\GetUserProvider;

#[ApiResource(
    shortName: 'User',
    operations: [
        new GetCollection(
            uriTemplate: '/users/get_all',
            security: 'is_granted("ROLE_ADMIN")',
            provider: GetUserCollectionProvider::class
        ),
        new Get(
            uriTemplate: '/users/get/{id}',
            uriVariables: 'id',
            security: 'is_granted("ROLE_ADMIN") or is_granted("ROLE_PLAYER")',
            provider: GetUserProvider::class
        ),
        new Post(
            uriTemplate: '/users/create',
            security: 'is_granted("PUBLIC_ACCESS")',
            processor: CreateUserProcessor::class,
        ),
        new Patch(
            uriTemplate: '/users/update/{id}',
            uriVariables: 'id',
            security: 'is_granted("IS_AUTHENTICATED_FULLY")',
            read: false,
            processor: UpdateUserProcessor::class
        ),
        new Post( // todo poprawić na delete
            uriTemplate: '/users/remove/{id}',
            uriVariables: 'id',
            security: 'is_granted("IS_AUTHENTICATED_FULLY")',
            processor: DeleteUserProcessor::class
        ),
//        new Delete(
//            uriTemplate: '/users/remove/{id}',
//            uriVariables: 'id',
//            security: 'is_granted("IS_AUTHENTICATED_FULLY")',
//            read: false,
//            processor: DeleteUserProcessor::class
//        ),
    ],
)]
class UserResource implements ResourceInterface
{
    #[ApiProperty(writable: false, identifier: true)]
    public ?int $id = null;

    public ?string $email = null;

    public ?string $firstName = null;

    public ?string $lastName = null;

    public ?string $password = null;

    public ?string $role = null;

    public ?iterable $inventory = null;

    public ?string $currency = null;

    public static function fromModel(object $model, array $excludedVars = []): object
    {
        $excludedVars[] = 'user';

        return ResourceFactory::fromModel(self::class, $model, $excludedVars);
    }
}
