<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Domain\DolarRatio\Model\DolarRatio;
use App\Domain\Shared\Command\CommandInterface;
use Webmozart\Assert\Assert;

readonly class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $firstName,
        public string $lastName,
        public string $password,
        public string $currency
    ) {
        Assert::lengthBetween($email, 5, 100);
        Assert::lengthBetween($firstName, 2, 50);
        Assert::lengthBetween($lastName, 2, 50);
        Assert::minLength($password, 8);
        Assert::email($email);
        Assert::inArray($this->currency, DolarRatio::SUPPORTED_CURRENCIES);
    }
}
