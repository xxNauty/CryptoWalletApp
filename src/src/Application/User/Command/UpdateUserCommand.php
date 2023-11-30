<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Domain\DolarRatio\Model\DolarRatio;
use App\Domain\Shared\Command\CommandInterface;
use Webmozart\Assert\Assert;

readonly class UpdateUserCommand implements CommandInterface
{
    public function __construct(
        public int $id,
        public string $password,
        public ?string $email = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $currency = null,
    ) {
        Assert::nullOrLengthBetween($email, 5, 100);
        Assert::nullOrLengthBetween($firstName, 2, 50);
        Assert::nullOrLengthBetween($lastName, 2, 50);
        Assert::nullOrEmail($email);
        Assert::nullOrInArray($this->currency, DolarRatio::SUPPORTED_CURRENCIES);
    }
}
