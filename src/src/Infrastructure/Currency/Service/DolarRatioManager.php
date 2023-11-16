<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\Service;

use App\Domain\Currency\Model\DolarRatio;
use App\Domain\Currency\Service\DolarRatioManagerInterface;
use App\Domain\Currency\Service\UpdateDolarRatioServiceInterface;
use DateTimeImmutable;
use Symfony\Component\Filesystem\Filesystem;

readonly class DolarRatioManager implements DolarRatioManagerInterface
{
    public function __construct(
        private UpdateDolarRatioServiceInterface $updateDolarRatioService,
        private Filesystem                       $filesystem
    ) {
        if (!$this->filesystem->exists('dolar_rates')) {
            $this->filesystem->mkdir('dolar_rates');
            $this->updateAll(initial: true);
        }
    }

    public function getData(string $chosenCurrency): array
    {
        $path = 'dolar_rates/'.strtoupper($chosenCurrency).'_rate.json';
        if(!$this->filesystem->exists($path)){
            $this->update($chosenCurrency, true);
        }
        return [
            'ratio' => json_decode(file_get_contents($path))->ratio,
            'last update' => json_decode(file_get_contents($path))->updatedAt,
        ];
    }

    public function updateAll(bool $initial = false): void
    {
        foreach (DolarRatio::SUPPORTED_CURRENCIES as $currency) {
            $this->update($currency, $initial);
        }
    }

    public function update(string $currency, bool $initial = false): void
    {
        if (!$this->filesystem->exists('dolar_rates/'.$currency.'_rate.json')) {
            $this->filesystem->touch('dolar_rates/'.$currency.'_rate.json');
        }

        $ratio = new DolarRatio(
            $currency,
            $initial ? 0 : $this->updateDolarRatioService->update($currency),
            new DateTimeImmutable('now'),
        );
        $this->filesystem->dumpFile('dolar_rates/'.$currency.'_rate.json', json_encode($ratio->toArray()));
    }
}
