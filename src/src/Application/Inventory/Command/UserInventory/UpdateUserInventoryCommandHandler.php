<?php

namespace App\Application\Inventory\Command\UserInventory;

use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Inventory\Repository\InventoryRepositoryInterface;
use App\Domain\Shared\Command\CommandHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;

class UpdateUserInventoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly InventoryRepositoryInterface $inventoryRepository,
        private readonly CurrencyRepositoryInterface $currencyRepository,
        private readonly Security $security
    ) {
    }

    public function __invoke(UpdateUserInventoryCommand $command): void
    {
        if (!in_array($command->symbol, $this->currencyRepository->getAllowedCurrencies())) {
            throw new NotFoundHttpException('This currency is not supported');
        }

        $inventory = $this->userRepository->find(
            $this->security->getUser()->id
        )->inventory;

        $content = $inventory->content ?? [];

        switch ($command->action) {
            case 'buy':
                $this->addCurrencyAmount($content, $command->amount, $command->symbol);
                break;

            case 'sell':
                $this->subtractCurrencyAmount($content, $command->amount, $command->symbol);
                break;

            default:
                throw new \Exception('Only sell and buy are allowed here');
        }

        $inventory->content = $content;

        $this->inventoryRepository->save($inventory);
    }

    private function addCurrencyAmount(array &$content, float $amount, string $symbol): void
    {
        if (!array_key_exists($symbol, $content)) {
            $content[$symbol] = $amount;
        } else {
            $content[$symbol] += $amount;
        }
    }

    private function subtractCurrencyAmount(array &$content, float $amount, string $symbol): void
    {
        if (!array_key_exists($symbol, $content)) {
            throw new NotFoundHttpException('You do not have any of this currency');
        } else {
            if ($content[$symbol] < $amount) {
                throw new NotFoundHttpException('You do not have enough currency to sell');
            } else {
                $content[$symbol] = bcsub($content[$symbol], $amount, 10);
// -= $amount;
            }
        }
    }
}
