<?php

namespace App\Infrastructure\DolarRatio\Service;

use App\Domain\DolarRatio\Model\DolarRatio;
use App\Domain\DolarRatio\Service\DolarRatioManagerInterface;
use App\Domain\DolarRatio\Service\UpdateDolarRatioServiceInterface;
use Symfony\Component\Filesystem\Filesystem;

class DolarRatioManager implements DolarRatioManagerInterface
{
    public function __construct(
        private UpdateDolarRatioServiceInterface $updateDolarRatioService,
        private Filesystem $filesystem
    ) {
        if (!$this->filesystem->exists('dollar_rates')) {
            $this->filesystem->mkdir('dollar_rates');
            $this->updateAll(initial: true);
        }
    }

    public function getData(string $chosenCurrency): DolarRatio
    {
        $path = 'dollar_rates/'.strtoupper($chosenCurrency).'_rate.json';
        if (!$this->filesystem->exists($path)) {
            $this->update($chosenCurrency, true);
        }

        return new DolarRatio(
            $chosenCurrency,
            json_decode(file_get_contents($path))->ratio,
            \DateTimeImmutable::createFromFormat('Y.m.d H:i:s', json_decode(file_get_contents($path))->updatedAt)
        );
    }

    public function updateAll(bool $initial = false): void
    {
        foreach (DolarRatio::SUPPORTED_CURRENCIES as $currency) {
            $this->update($currency, $initial);
        }
    }

    public function update(string $currency, bool $initial = false): void
    {
        if (!$this->filesystem->exists('dollar_rates/'.$currency.'_rate.json')) {
            $this->filesystem->touch('dollar_rates/'.$currency.'_rate.json');
        }

        $ratio = new DolarRatio(
            $currency,
            $initial ? 0 : $this->updateDolarRatioService->update($currency),
            new \DateTimeImmutable('now'),
        );
        $this->filesystem->dumpFile('dollar_rates/'.$currency.'_rate.json', json_encode($ratio->toArray()));
    }
}
