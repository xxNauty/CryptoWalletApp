<?php

declare(strict_types=1);

namespace App\Application\Currency\Command;

use App\Application\Shared\Command\CommandHandlerInterface;
use App\Domain\Currency\Model\Currency;
use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateCurrencyCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository
    ) {
    }

    public function __invoke(UpdateCurrencyCommand $command): Currency
    {
        $currency = $this->currencyRepository->find($command->id);

        if (null === $currency) {
            throw new NotFoundHttpException('Nie znaleziono waluty o podanym ID');
        }

        $currency->symbol = $command->symbol ?? $currency->symbol;
        $currency->name = $command->name ?? $currency->name;

        $this->currencyRepository->save($currency);

        return $currency;
    }
}
