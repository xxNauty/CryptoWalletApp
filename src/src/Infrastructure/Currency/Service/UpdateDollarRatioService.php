<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\Service;

use App\Domain\Currency\Service\UpdateDollarRatioServiceInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Webmozart\Assert\Assert;

readonly class UpdateDollarRatioService implements UpdateDollarRatioServiceInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $dollarRatioApiUrl,
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
            $this->dollarRatioApiUrl
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
