<?php

declare(strict_types=1);

namespace App\Application\Currency\Command;

use App\Domain\Currency\Model\Currency;
use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Shared\Command\CommandHandlerInterface;

class CreateCurrencyCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository,
    ) {
    }

    public function __invoke(CreateCurrencyCommand $command): Currency
    {
        $currency = new Currency(
            $command->symbol,
            $command->name,
            $command->startPriceUSD,
            0,
            0,
            0,
        );

        $this->currencyRepository->save($currency);

        return $currency;
    }
}
