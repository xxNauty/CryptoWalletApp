<?php

namespace App\Infrastructure\User\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\User\Query\FindOwnDataQuery;
use App\Application\User\Query\FindUserQuery;
use App\Domain\Shared\Query\QueryBusInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Service\UserSecurityServiceInterface;
use App\Infrastructure\User\ApiPlatform\Resource\UserResource;

readonly class GetUserProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private UserSecurityServiceInterface $securityService
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $user = $this->securityService->getUser();

        /** @var User|null $model */
        $model = (User::ROLE_PLAYER == $user->role)
            ? $this->queryBus->ask(new FindOwnDataQuery($user))
            : $this->queryBus->ask(new FindUserQuery($uriVariables['id']));

        return null !== $model ? UserResource::fromModel($model) : null;
    }
}
