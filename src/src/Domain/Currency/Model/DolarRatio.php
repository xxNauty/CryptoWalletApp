<?php

declare(strict_types=1);

namespace App\Domain\Currency\Model;

use Webmozart\Assert\Assert;

class DolarRatio
{
    public const CURRENCY_PLN = 'PLN';
    public const CURRENCY_EUR = 'EUR';
    public const CURRENCY_CHF = 'CHF';
    public const CURRENCY_GBP = 'GBP';
    public const DEFAULT_CURRENCY = 'USD';

    public const SUPPORTED_CURRENCIES = [
        self::CURRENCY_PLN,
        self::CURRENCY_EUR,
        self::CURRENCY_CHF,
        self::CURRENCY_GBP,
        self::DEFAULT_CURRENCY
    ];

    public function __construct(
        public string $currencyTo,
        public float $ratio,
        public \DateTimeImmutable $lastUpdate,
    ) {
        Assert::inArray($this->currencyTo, self::SUPPORTED_CURRENCIES);
        $this->ratio = round($ratio, 2);
        $this->lastUpdate = new \DateTimeImmutable('now');
    }

    public function toArray(): array
    {
        return [
            'ratio' => $this->ratio,
            'updatedAt' => $this->lastUpdate->format('Y.m.d H:i:s'),
        ];
    }
}
