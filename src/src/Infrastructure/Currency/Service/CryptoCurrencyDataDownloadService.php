<?php

declare(strict_types=1);


namespace App\Infrastructure\Currency\Service;

use App\Domain\Currency\Model\Currency;
use App\Domain\Currency\Service\CryptoCurrencyDataDownloadServiceInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CryptoCurrencyDataDownloadService implements CryptoCurrencyDataDownloadServiceInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $cryptoApiUrl,
    ){
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function create(int $identifier): Currency
    {
        $response = $this->client->request(
            'GET',
            $this->cryptoApiUrl.$identifier,
        );

        $response = $response->toArray()[0];

        return new Currency(
            $identifier,
            $response['symbol'],
            $response['name'],
            (float) $response['price_usd'],
            (float) $response['percent_change_1h'] == 0
                ? 0
                : (
                    $response['percent_change_1h'] > 0
                        ? 1
                        : -1
            ),
            (float) $response['percent_change_24h'] == 0
                ? 0
                : (
                    $response['percent_change_24h']  > 0
                        ? 1
                        : -1
            ),
            (float) $response['percent_change_7d'] == 0
                ? 0
                : (
                    $response['percent_change_7d'] > 0
                        ? 1
                        : -1
            ),
        );
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function update(Currency $currency): Currency
    {
        $response = $this->client->request(
            'GET',
            $this->cryptoApiUrl.$currency->id,
        );

        $response = $response->toArray()[0];

        $currency->priceUSD = (float) $response['price_usd'];
        $currency->change1h =
            (float) $response['percent_change_1h'] == 0
                ? 0
                : (
                    $response['percent_change_1h'] > 0
                        ? 1
                        : -1
                    );
        $currency->change24h =
            (float) $response['percent_change_24h'] == 0
                ? 0
                : (
                    $response['percent_change_24h'] > 0
                        ? 1
                        : -1
                    );
        $currency->change7d =
            (float) $response['percent_change_7d'] == 0
                ? 0
                : (
                    $response['percent_change_7d'] > 0
                        ? 1
                        : -1
                    );

        return $currency;
    }
}