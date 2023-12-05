<?php

declare(strict_types=1);

namespace App\Application\Currency\Command;

use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Purchase\Resource\PurchaseRepositoryInterface;
use App\Domain\Shared\Command\CommandHandlerInterface;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class DeleteCurrencyCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CurrencyRepositoryInterface $currencyRepository,
        private PurchaseRepositoryInterface $purchaseRepository
    ) {
    }

    public function __invoke(DeleteCurrencyCommand $command): void
    {
        if (null === $currency = $this->currencyRepository->find($command->id)) {
            throw new NotFoundHttpException('There is no currency with that ID');
        }

        if (in_array($currency->symbol, $this->purchaseRepository->findUsedCurrencies())) {
            throw new AccessDeniedException("You can not delete currency which is in somebody's wallet");
        }

        $this->currencyRepository->remove($currency);
    }
}
