<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\Service;

use App\Domain\Currency\Model\DolarRatios\USDtoPLN;
use App\Domain\Currency\Service\UpdateDolarRatioServiceInterface;
use Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Webmozart\Assert\Assert;

class UpdateDolarRatioService implements UpdateDolarRatioServiceInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
    ) {
    }

    // todo znaleść api do innych walut

    public function update(string $currency): float
    {
        Assert::inArray($currency, ['PLN', 'EUR', 'CHF', 'GBP']);

        switch ($currency) {
            case 'PLN':
                $response = $this->client->request(
                    'GET',
                    'http://api.nbp.pl/api/exchangerates/rates/A/USD'
                );
                return round($response->toArray()['rates'][0]['mid'], 2);
        }
        return -1;
    }
}
