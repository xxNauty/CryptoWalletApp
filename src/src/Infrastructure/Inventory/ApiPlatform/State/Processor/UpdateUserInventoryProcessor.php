<?php

namespace App\Infrastructure\Inventory\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Inventory\Command\UserInventory\UpdateUserInventoryCommand;
use App\Domain\Shared\Command\CommandBusInterface;

class UpdateUserInventoryProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        return $this->commandBus->dispatch(new UpdateUserInventoryCommand($data->action, $data->symbol, $data->amount));
    }
}
