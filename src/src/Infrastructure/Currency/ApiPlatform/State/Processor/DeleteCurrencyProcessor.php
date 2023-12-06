<?php

namespace App\Infrastructure\Currency\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Currency\Command\DeleteCurrencyCommand;
use App\Domain\Shared\Command\CommandBusInterface;
use App\Infrastructure\Currency\ApiPlatform\Resource\CurrencyResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

readonly class DeleteCurrencyProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JsonResponse
    {
        Assert::isInstanceOf($data, CurrencyResource::class);
        /* @var CurrencyResource $data */

        $this->commandBus->dispatch(
            new DeleteCurrencyCommand(
                $uriVariables['id']
            )
        );

        return new JsonResponse('Currency deleted', Response::HTTP_OK);
    }
}
