<?php

declare(strict_types=1);

namespace App\Domain\Currency\Model\DolarRatios;

use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

abstract class DolarRatios
{
    private static array $instances = [];

    private function __construct()
    {

    }

    private function __clone(): void
    {

    }

    public static function getInstance(): self
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    public float $ratio;

    public DateTimeImmutable $lastUpdate;

    public function updateValue(float $value): void
    {
        $this->ratio = $value;
        $this->lastUpdate = new DateTimeImmutable('now');
    }
}