<?php

namespace App\Infrastructure\Currency\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Currency\Command\DeleteCurrencyCommand;
use App\Domain\Shared\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteCurrencyProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JsonResponse
    {
        $this->commandBus->dispatch(new DeleteCurrencyCommand($uriVariables['id']));

        return new JsonResponse('', 204);
    }
}