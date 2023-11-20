<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\Service;

use App\Domain\Currency\Service\UpdateDolarRatioServiceInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Webmozart\Assert\Assert;

readonly class UpdateDolarRatioService implements UpdateDolarRatioServiceInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $dolarRatioApiUrl,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function update(string $currency): float
    {
        Assert::inArray($currency, ['PLN', 'EUR', 'CHF', 'GBP']);

        $response = $this->client->request(
            'GET',
            $this->dolarRatioApiUrl
        );
        $rates = $response->toArray()['data'];

        return match ($currency) {
            'PLN' => $rates['PLN'],
            'EUR' => $rates['EUR'],
            'GBP' => $rates['GBP'],
            'CHF' => $rates['CHF'],
            default => -1,
        };
    }
}
