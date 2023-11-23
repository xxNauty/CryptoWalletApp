<?php

namespace App\Infrastructure\Currency\ApiPlatform\State\Provider\CryptoCurrency;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Currency\Query\FindAvailableCurrenciesQuery;
use App\Domain\Shared\Query\QueryBusInterface;

readonly class GetAllowedCurrenciesProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->queryBus->ask(new FindAvailableCurrenciesQuery());
    }
}
