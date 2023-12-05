<?php

declare(strict_types=1);

namespace App\Infrastructure\DolarRatio\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\DolarRatio\Command\UpdateRatiosCommand;
use App\Domain\Shared\Command\CommandBusInterface;
use App\Infrastructure\DolarRatio\ApiPlatform\Resource\DollarRatiosResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

readonly class UpdateAllRatiosProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JsonResponse
    {
        Assert::isInstanceOf($data, DollarRatiosResource::class);
        /** @var DollarRatiosResource $data */

        $this->commandBus->dispatch(
            new UpdateRatiosCommand()
        );

        return new JsonResponse('Updated', Response::HTTP_OK);
    }
}
