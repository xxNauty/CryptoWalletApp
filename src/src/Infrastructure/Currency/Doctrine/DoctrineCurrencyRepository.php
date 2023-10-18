<?php

declare(strict_types=1);

namespace App\Infrastructure\Currency\Doctrine;

use App\Domain\Currency\Model\Currency;
use App\Domain\Currency\Repository\CurrencyRepositoryInterface;
use App\Infrastructure\Shared\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineCurrencyRepository extends DoctrineRepository implements CurrencyRepositoryInterface
{
    private const ENTITY_CLASS = Currency::class;
    private const ALIAS = 'currency';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(Currency $currency): void
    {
        $this->em->persist($currency);
        $this->em->flush();
    }

    public function remove(Currency $currency): void
    {
        $this->em->remove($currency);
        $this->em->flush();
    }

    public function find(int $id): ?Currency
    {
        $this->em->find(self::ENTITY_CLASS, $id);
    }
}
