<?php

namespace App\Application\Inventory\Command\UserInventory;

use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Inventory\Repository\InventoryRepositoryInterface;
use App\Domain\Purchase\Model\Purchase;
use App\Domain\Purchase\Resource\PurchaseRepositoryInterface;
use App\Domain\Shared\Command\CommandHandlerInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class UpdateUserInventoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private InventoryRepositoryInterface $inventoryRepository,
        private CurrencyRepositoryInterface $currencyRepository,
        private UserSecurityServiceInterface $securityService,
        private PurchaseRepositoryInterface $purchaseRepository,
    ) {
    }

    public function __invoke(UpdateUserInventoryCommand $command): void
    {
        if (!in_array($command->symbol, $this->currencyRepository->getAllowedCurrencies())) {
            throw new NotFoundHttpException('This currency is not supported');
        }

        $inventory = $this->securityService->getUser()->inventory;

        $purchase = new Purchase(
            $command->symbol,
            $command->amount,
            $this->currencyRepository->findBy(['symbol' => $command->symbol])->priceUSD,
            new \DateTimeImmutable('now'),
            match ($command->action){
                'buy' => false,
                'sell' => true,
            },
            $inventory
        );

        $this->inventoryRepository->save($inventory);
        $this->purchaseRepository->save($purchase);
    }
}
