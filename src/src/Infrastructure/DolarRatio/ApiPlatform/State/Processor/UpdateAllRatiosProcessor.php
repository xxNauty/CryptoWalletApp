<?php

declare(strict_types=1);

namespace App\Infrastructure\DolarRatio\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\DolarRatio\Command\UpdateRatiosCommand;
use App\Domain\Shared\Command\CommandBusInterface;
use App\Infrastructure\DolarRatio\ApiPlatform\Resource\DollarRatiosResource;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Webmozart\Assert\Assert;

class UpdateAllRatiosProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {
    }

    /**
     * @throws Exception
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JsonResponse
    {
        Assert::isInstanceOf($data, DollarRatiosResource::class);

        $this->commandBus->dispatch(new UpdateRatiosCommand());

        return new JsonResponse('Updated', 200);
    }
}
