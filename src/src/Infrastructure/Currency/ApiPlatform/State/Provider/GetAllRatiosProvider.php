<?php

declare(strict_types=1);


namespace App\Infrastructure\Currency\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Currency\Query\DolarRatios\GetAllRatiosQuery;
use App\Domain\Shared\Query\QueryBusInterface;

class GetAllRatiosProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->queryBus->ask(new GetAllRatiosQuery());
    }
}