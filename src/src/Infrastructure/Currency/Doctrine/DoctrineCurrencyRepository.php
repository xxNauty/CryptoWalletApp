<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\Doctrine;

use App\Domain\Currency\Model\CryptoCurrency;
use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Infrastructure\Shared\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineCurrencyRepository extends DoctrineRepository implements CurrencyRepositoryInterface
{
    private const ENTITY_CLASS = CryptoCurrency::class;
    private const ALIAS = 'currency';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(CryptoCurrency $currency): void
    {
        $this->em->persist($currency);
        $this->em->flush();
    }

    public function remove(CryptoCurrency $currency): void
    {
        $this->em->remove($currency);
        $this->em->flush();
    }

    public function find(int $id): ?CryptoCurrency
    {
        return $this->em->find(self::ENTITY_CLASS, $id);
    }

    public function getAvailableCurrencies(): ?array
    {
        $currencies = $this->query()
            ->select('currency.symbol')
            ->getQuery()
            ->getArrayResult();

        $symbols = [];

        foreach ($currencies as $currency) {
            $symbols[] = $currency['symbol'];
        }

        return $symbols;
    }

    public function getAvailableCurrenciesNames(): ?array
    {
        $currencies = $this->query()
            ->select('currency.name')
            ->getQuery()
            ->getArrayResult();

        $symbols = [];

        foreach ($currencies as $currency) {
            $symbols[] = $currency['name'];
        }

        return $symbols;
    }

    public function findBy(array $params): ?CryptoCurrency
    {
        return $this->em->getRepository(self::ENTITY_CLASS)->findOneBy($params);
    }
}
