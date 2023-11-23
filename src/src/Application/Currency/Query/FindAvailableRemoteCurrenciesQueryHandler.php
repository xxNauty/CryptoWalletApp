<?php

namespace App\Application\Currency\Query;

use App\Domain\Shared\Query\QueryHandlerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class FindAvailableRemoteCurrenciesQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $cryptoApiUrlGetAll,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function __invoke(FindAvailableRemoteCurrenciesQuery $query): array
    {
        return $this->client->request(
            'GET',
            $this->cryptoApiUrlGetAll
        )->toArray();
    }
}
