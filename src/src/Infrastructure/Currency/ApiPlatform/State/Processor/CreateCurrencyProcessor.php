<?php

namespace App\Infrastructure\Currency\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Currency\Command\CreateCurrencyCommand;
use App\Domain\Shared\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateCurrencyProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $this->commandBus->dispatch(
            new CreateCurrencyCommand(
                $data->id,
            )
        );

        return new JsonResponse('', 201);
    }
}
