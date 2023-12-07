<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Currency\Command\UpdateCurrencyCommand;
use App\Application\Currency\Query\FindCurrencyQuery;
use App\Domain\Shared\Command\CommandBusInterface;
use App\Domain\Shared\Query\QueryBusInterface;
use App\Infrastructure\Currency\ApiPlatform\Resource\CurrencyResource;

readonly class CurrencyCrudProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // todo Do przemyślenia czy zostawić
        $this->commandBus->dispatch(
            new UpdateCurrencyCommand(
                $uriVariables['id']
            )
        );

        $model = $this->queryBus->ask(
            new FindCurrencyQuery($uriVariables['id']
            )
        );

        return CurrencyResource::fromModel($model);
    }
}
