<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\ApiPlatform\State\Provider\CryptoCurrency;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Currency\Command\UpdateCurrencyCommand;
use App\Application\Currency\Query\FindCurrencyQuery;
use App\Domain\Shared\Command\CommandBusInterface;
use App\Domain\Shared\Query\QueryBusInterface;

readonly class CurrencyCrudProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $this->commandBus->dispatch(new UpdateCurrencyCommand($uriVariables['id']));

        return $this->queryBus->ask(new FindCurrencyQuery($uriVariables['id']));
    }
}
