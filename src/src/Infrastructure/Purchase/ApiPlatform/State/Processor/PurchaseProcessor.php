<?php

namespace App\Infrastructure\Purchase\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Purchase\Command\PurchaseCommand;
use App\Application\Purchase\Command\PurchaseSaleCommand;
use App\Domain\Shared\Command\CommandBusInterface;
use App\Infrastructure\Purchase\ApiPlatform\Resource\PurchaseResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

readonly class PurchaseProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JsonResponse
    {
        Assert::isInstanceOf($data, PurchaseResource::class);
        /** @var PurchaseResource $data */
        if ($data->sold) {
            $this->commandBus->dispatch(
                new PurchaseSaleCommand(
                    $data->symbol,
                    $data->amount
                )
            );

            return new JsonResponse('Sold', Response::HTTP_CREATED);
        } else {
            $this->commandBus->dispatch(
                new PurchaseCommand(
                    $data->symbol,
                    $data->amount,
                )
            );

            return new JsonResponse('Bought', Response::HTTP_CREATED);
        }
    }
}
