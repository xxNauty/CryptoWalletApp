<?php

namespace App\Application\Purchase\Command;

use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Purchase\Model\Purchase;
use App\Domain\Purchase\Resource\PurchaseRepositoryInterface;
use App\Domain\Shared\Command\CommandHandlerInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;

readonly class PurchaseCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private PurchaseRepositoryInterface $purchaseRepository,
        private CurrencyRepositoryInterface $currencyRepository,
        private UserSecurityServiceInterface $securityService
    ) {
    }

    public function __invoke(PurchaseCommand $command): void
    {
        $purchase = new Purchase(
            $command->symbol,
            $command->amount,
            $this->currencyRepository->findBy(['symbol' => $command->symbol])->priceUSD,
            new \DateTimeImmutable('now'),
            false,
            $this->securityService->getUser()
        );

        $this->purchaseRepository->save($purchase);
    }
}
