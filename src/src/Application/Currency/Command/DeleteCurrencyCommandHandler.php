<?php

declare(strict_types=1);

namespace App\Application\Currency\Command;

use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Shared\Command\CommandHandlerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteCurrencyCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository
    ) {
    }

    public function __invoke(DeleteCurrencyCommand $command): void
    {
        if (null === $currency = $this->currencyRepository->find($command->id)) {
            throw new NotFoundHttpException('There is no currency with that ID');
        }

        $this->currencyRepository->remove($currency);
    }
}
