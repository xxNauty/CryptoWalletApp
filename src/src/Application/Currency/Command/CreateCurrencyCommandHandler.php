<?php

declare(strict_types=1);

namespace App\Application\Currency\Command;

use App\Domain\Currency\Model\CryptoCurrency;
use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Currency\Service\CryptoCurrencyDataDownloadServiceInterface;
use App\Domain\Shared\Command\CommandHandlerInterface;

readonly class CreateCurrencyCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CurrencyRepositoryInterface $currencyRepository,
        private CryptoCurrencyDataDownloadServiceInterface $cryptoCurrencyDataDownloadService
    ) {
    }

    public function __invoke(CreateCurrencyCommand $command): CryptoCurrency
    {
        $currency = $this->cryptoCurrencyDataDownloadService->create($command->apiId);

        $this->currencyRepository->save($currency);

        return $currency;
    }
}
