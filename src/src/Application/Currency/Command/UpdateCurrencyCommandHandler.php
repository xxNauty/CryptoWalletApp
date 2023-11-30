<?php

declare(strict_types=1);

namespace App\Application\Currency\Command;

use App\Domain\Currency\Model\CryptoCurrency;
use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Domain\Currency\Service\CryptoCurrencyDataDownloadServiceInterface;
use App\Domain\Shared\Command\CommandHandlerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class UpdateCurrencyCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CurrencyRepositoryInterface                $currencyRepository,
        private CryptoCurrencyDataDownloadServiceInterface $cryptoCurrencyDataDownloadService
    ) {
    }

    public function __invoke(UpdateCurrencyCommand $command): CryptoCurrency
    {
        $currency = $this->currencyRepository->findBy(['symbol' => $command->symbol]);

        if (null === $currency) {
            throw new NotFoundHttpException('There is no currency with that ID');
        }

        $currency = $this->cryptoCurrencyDataDownloadService->update($currency);

        $this->currencyRepository->save($currency);

        return $currency;
    }
}
