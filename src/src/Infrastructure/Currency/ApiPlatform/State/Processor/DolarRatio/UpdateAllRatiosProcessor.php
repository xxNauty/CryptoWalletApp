<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\ApiPlatform\State\Processor\DolarRatio;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Currency\Command\DolarRatio\UpdateRatiosCommand;
use App\Domain\Shared\Command\CommandBusInterface;

class UpdateAllRatiosProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $this->commandBus->dispatch(new UpdateRatiosCommand());
    }
}
