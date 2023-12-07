<?php

namespace App\Application\Purchase\Command;

use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Purchase\Model\Purchase;
use App\Domain\Purchase\Resource\PurchaseRepositoryInterface;
use App\Domain\Purchase\Service\InventoryValueServiceInterface;
use App\Domain\Shared\Command\CommandHandlerInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

readonly class PurchaseSaleCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private PurchaseRepositoryInterface $purchaseRepository,
        private CurrencyRepositoryInterface $currencyRepository,
        private UserSecurityServiceInterface $securityService,
        private InventoryValueServiceInterface $inventoryValueService
    ) {
    }

    public function __invoke(PurchaseSaleCommand $command): void
    {
        $user = $this->securityService->getUser();

        if (!in_array($command->symbol, $this->purchaseRepository->getUsersCurrencies($user))) {
            throw new UnprocessableEntityHttpException('You do not have any of this currency');
        }

        if ($command->amount > $this->inventoryValueService->getCountOfCurrency($user, $command->symbol)) {
            throw new UnprocessableEntityHttpException('You do not have enough currency to sell');
        }

        $purchase = new Purchase(
            $command->symbol,
            $command->amount,
            $this->currencyRepository->findBy(['symbol' => $command->symbol])->priceUSD,
            new \DateTimeImmutable('now'),
            true,
            $this->securityService->getUser()
        );

        $this->purchaseRepository->save($purchase);
    }
}
