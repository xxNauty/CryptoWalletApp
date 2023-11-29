<?php

namespace App\Infrastructure\Currency\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Currency\Command\UpdateCurrencyCommand;
use App\Domain\Shared\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateCurrencyProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $this->commandBus->dispatch(
            new UpdateCurrencyCommand(
                $uriVariables['id'],
            )
        );

        return new JsonResponse('', 200);
    }
}