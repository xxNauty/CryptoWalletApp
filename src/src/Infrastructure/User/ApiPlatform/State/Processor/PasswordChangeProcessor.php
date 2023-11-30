<?php

namespace App\Infrastructure\User\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\User\Command\UpdateUserPasswordCommand;
use App\Domain\Shared\Command\CommandBusInterface;
use App\Infrastructure\User\ApiPlatform\Resource\UserResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Webmozart\Assert\Assert;

class PasswordChangeProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    )
    {
    }


    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JsonResponse
    {
        Assert::isInstanceOf($data, UpdateUserPasswordCommand::class);

        $this->commandBus->dispatch(
            new UpdateUserPasswordCommand(
                $data->oldPassword,
                $data->newPassword,
            )
        );

        return new JsonResponse('', 200);
    }
}