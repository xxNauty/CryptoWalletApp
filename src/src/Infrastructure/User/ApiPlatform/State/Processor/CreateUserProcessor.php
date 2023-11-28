<?php

namespace App\Infrastructure\User\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\User\Command\CreateUserCommand;
use App\Domain\Shared\Command\CommandBusInterface;
use App\Infrastructure\User\ApiPlatform\Resource\UserResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Webmozart\Assert\Assert;

readonly class CreateUserProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus
    ) {
    }

    /**
     * @throws \Exception
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JsonResponse
    {
        Assert::isInstanceOf($data, UserResource::class);

        /* @var UserResource $data */
        try {
            $this->commandBus->dispatch(
                new CreateUserCommand(
                    $data->email,
                    $data->firstName,
                    $data->lastName,
                    $data->password,
                    $data->currency
                )
            );
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        return new JsonResponse('Created', 201);
    }
}
