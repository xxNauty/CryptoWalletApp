<?php

declare(strict_types=1);

namespace App\Application\Currency\Command;

use App\Domain\Currency\Model\Currency;
use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Currency\Service\CryptoCurrencyDataDownloadServiceInterface;
use App\Domain\Shared\Command\CommandHandlerInterface;

class CreateCurrencyCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository,
        private readonly CryptoCurrencyDataDownloadServiceInterface $cryptoCurrencyDataDownloadService
    ) {
    }

    public function __invoke(CreateCurrencyCommand $command): Currency
    {
        $currency = $this->cryptoCurrencyDataDownloadService->create($command->apiId);

        $this->currencyRepository->save($currency);

        return $currency;
    }
}
