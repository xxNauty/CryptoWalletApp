<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\Service;

use App\Domain\Currency\Model\CryptoCurrency;
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
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function create(int $identifier): CryptoCurrency
    {
        $response = $this->client->request(
            'GET',
            $this->cryptoApiUrl.$identifier,
        );

        if($response->getContent() == '' || $response->getContent() == '[]'){
            throw new \Exception("There is no currency with this ID");
        }

        $response = $response->toArray()[0];

        return new CryptoCurrency(
            $identifier,
            $response['symbol'],
            $response['name'],
            (float) $response['price_usd'],
            0 == (float) $response['percent_change_1h']
                ? 0
                : (
                    $response['percent_change_1h'] > 0
                        ? 1
                        : -1
                ),
            0 == (float) $response['percent_change_24h']
                ? 0
                : (
                    $response['percent_change_24h'] > 0
                        ? 1
                        : -1
                ),
            0 == (float) $response['percent_change_7d']
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
    public function update(CryptoCurrency $currency): CryptoCurrency
    {
        $response = $this->client->request(
            'GET',
            $this->cryptoApiUrl.$currency->id,
        );

        $response = $response->toArray()[0];

        $currency->priceUSD = (float) $response['price_usd'];
        $currency->change1h =
            0 == (float) $response['percent_change_1h']
                ? 0
                : (
                    $response['percent_change_1h'] > 0
                        ? 1
                        : -1
                );
        $currency->change24h =
            0 == (float) $response['percent_change_24h']
                ? 0
                : (
                    $response['percent_change_24h'] > 0
                        ? 1
                        : -1
                );
        $currency->change7d =
            0 == (float) $response['percent_change_7d']
                ? 0
                : (
                    $response['percent_change_7d'] > 0
                        ? 1
                        : -1
                );

        return $currency;
    }
}
