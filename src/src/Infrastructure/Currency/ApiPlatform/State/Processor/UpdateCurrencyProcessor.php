<?php

namespace App\Infrastructure\Currency\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Currency\Command\UpdateCurrencyCommand;
use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Shared\Command\CommandBusInterface;
use App\Infrastructure\Currency\ApiPlatform\Resource\CurrencyResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

readonly class UpdateCurrencyProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface         $commandBus,
        private CurrencyRepositoryInterface $currencyRepository
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JsonResponse
    {
        Assert::isInstanceOf($data, CurrencyResource::class);
        /** @var CurrencyResource $data */

        $currenciesList = $this->currencyRepository->getAvailableCurrencies();

        foreach ($currenciesList as $currency) {
            /** @var string $currency */
            $this->commandBus->dispatch(
                new UpdateCurrencyCommand(
                    $currency,
                )
            );
        }

        return new JsonResponse('Currencies updated', Response::HTTP_OK);
    }
}
