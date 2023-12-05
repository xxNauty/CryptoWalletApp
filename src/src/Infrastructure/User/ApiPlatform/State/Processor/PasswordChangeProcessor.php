<?php

declare(strict_types=1);

namespace App\Infrastructure\User\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\User\Command\UpdateUserPasswordCommand;
use App\Domain\Shared\Command\CommandBusInterface;
use App\Infrastructure\User\ApiPlatform\Resource\UserResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

readonly class PasswordChangeProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JsonResponse
    {
        Assert::isInstanceOf($data, UserResource::class);
        /* @var UserResource $data */

        $this->commandBus->dispatch(
            new UpdateUserPasswordCommand(
                $data->password,
                $data->newPassword,
            )
        );

        return new JsonResponse('Password updated', Response::HTTP_OK);
    }
}
