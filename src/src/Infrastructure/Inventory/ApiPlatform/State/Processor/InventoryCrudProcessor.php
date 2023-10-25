<?php

declare(strict_types=1);

namespace App\Infrastructure\Inventory\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Inventory\Command\CreateInventoryCommand;
use App\Application\Inventory\Command\DeleteInventoryCommand;
use App\Application\Inventory\Command\UpdateInventoryCommand;
use App\Application\Shared\Command\CommandBusInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Inventory\ApiPlatform\Resource\InventoryResource;
use Webmozart\Assert\Assert;

class InventoryCrudProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($data, InventoryResource::class);

        if ($operation instanceof DeleteOperationInterface) {
            $this->commandBus->dispatch(new DeleteInventoryCommand($uriVariables['id']));
        }

        $command = !isset($uriVariables['id'])
            ? new CreateInventoryCommand(
                $this->userRepository->find($data->user->id),
            )
            : new UpdateInventoryCommand(
                $uriVariables['id'],
                $this->userRepository->find($data->user->id),
            );

        $model = $this->commandBus->dispatch($command);

        return InventoryResource::fromModel($model);
    }
}
