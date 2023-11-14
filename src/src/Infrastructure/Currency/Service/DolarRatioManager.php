<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\Service;

use _PHPStan_c6b09fbdf\Nette\Neon\Exception;
use App\Domain\Currency\Model\DolarRatio;
use App\Domain\Currency\Service\DolarRatioManagerInterface;
use App\Domain\Currency\Service\UpdateDolarRatioServiceInterface;
use DateTimeImmutable;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class DolarRatioManager implements DolarRatioManagerInterface
{
    public function __construct(
        private UpdateDolarRatioServiceInterface $updateDolarRatioService,
        private Filesystem $filesystem
    ){
        if(!$this->filesystem->exists('dolar_rates')){
            $this->filesystem->mkdir('dolar_rates');
        }
        $this->initialise();
    }

    public function getData(string $chosenCurrency)
    {
        $path = "dolar_rates/".strtoupper($chosenCurrency)."_rate.json";
        return json_decode(file_get_contents($path))->ratio;
    }

    public function updateAll(bool $initial = false): void
    {
        foreach (DolarRatio::SUPPORTED_CURRENCIES as $currency) {
            if(!$this->filesystem->exists('dolar_rates/'.$currency.'_rate.json')){
                $this->filesystem->touch('dolar_rates/'.$currency.'_rate.json');
            }

            $ratio  = new DolarRatio(
                $currency,
                $initial ? 0 : $this->updateDolarRatioService->update($currency),
            );
            $this->filesystem->dumpFile('dolar_rates/'.$currency.'_rate.json', json_encode($ratio->toArray()));
        }
    }
}