<?php

namespace App\Infrastructure\Currency\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Currency\Command\UpdateCurrencyCommand;
use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Purchase\Resource\PurchaseRepositoryInterface;
use App\Domain\Shared\Command\CommandBusInterface;
use App\Infrastructure\Currency\ApiPlatform\Resource\CurrencyResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateCurrencyProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly CurrencyRepositoryInterface $currencyRepository
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JsonResponse
    {
        $currenciesList = $this->currencyRepository->getAvailableCurrencies();

        foreach ($currenciesList as $currency) {
            $this->commandBus->dispatch(
                new UpdateCurrencyCommand(
                    $currency,
                )
            );
        }

        return new JsonResponse('', 200);
    }
}
