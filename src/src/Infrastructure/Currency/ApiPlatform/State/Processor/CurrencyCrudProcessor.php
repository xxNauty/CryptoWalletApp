<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Currency\Command\CreateCurrencyCommand;
use App\Application\Currency\Command\DeleteCurrencyCommand;
use App\Application\Currency\Command\UpdateCurrencyCommand;
use App\Domain\Shared\Command\CommandBusInterface;
use App\Infrastructure\Currency\ApiPlatform\Resource\CurrencyResource;
use Webmozart\Assert\Assert;

class CurrencyCrudProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        //        Assert::isInstanceOf($data, CurrencyResource::class);

        if ($operation instanceof DeleteOperationInterface) {
            $this->commandBus->dispatch(new DeleteCurrencyCommand($uriVariables['id']));
        }

        $command = !isset($uriVariables['id'])
            ? new CreateCurrencyCommand(
                $data->apiId,
            )
            : new UpdateCurrencyCommand(
                $uriVariables['id'],
            )
        ;

        $model = $this->commandBus->dispatch($command);

        return CurrencyResource::fromModel($model);
    }
}
