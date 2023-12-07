<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Currency\Query\FindCurrencyQuery;
use App\Domain\Shared\Query\QueryBusInterface;
use App\Infrastructure\Currency\ApiPlatform\Resource\CurrencyResource;

readonly class CurrencyCrudProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
<<<<<<< HEAD
        // todo Do przemyślenia czy zostawić
        $this->commandBus->dispatch(
            new UpdateCurrencyCommand(
                $uriVariables['id']
            )
        );

=======
>>>>>>> origin/develop
        $model = $this->queryBus->ask(
            new FindCurrencyQuery(
                $uriVariables['symbol']
            )
        );

        return CurrencyResource::fromModel($model);
    }
}
