<?php

declare(strict_types=1);

namespace App\Infrastructure\User\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Shared\Command\CommandBusInterface;
use App\Application\User\Command\CreateUserCommand;
use App\Application\User\Command\DeleteUserCommand;
use App\Application\User\Command\UpdateUserCommand;
use App\Infrastructure\User\ApiPlatform\Resource\UserResource;
use Webmozart\Assert\Assert;

final class UserCrudProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($data, UserResource::class);

        if ($operation instanceof DeleteOperationInterface) {
            $this->commandBus->dispatch(new DeleteUserCommand($uriVariables['id']));

            return null;
        }

        $command = !isset($uriVariables['id'])
            ? new CreateUserCommand(
                $data->email,
                $data->firstName,
                $data->lastName,
                $data->password
            )
            : new UpdateUserCommand(
                $uriVariables['id'],
                $data->email,
                $data->firstName,
                $data->lastName,
                $data->password
            )
        ;

        $model = $this->commandBus->dispatch($command);

        return UserResource::fromModel($model);
    }
}
