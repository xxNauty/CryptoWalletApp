<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Domain\Currency\Model\DolarRatio;
use App\Domain\Shared\Command\CommandInterface;
use ContainerODEX8Ql\getMessenger_Middleware_RejectRedeliveredMessageMiddlewareService;
use Webmozart\Assert\Assert;

class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public readonly string $email,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $password,
        public readonly string $currency
    ) {
        Assert::lengthBetween($email, 5, 100);
        Assert::lengthBetween($firstName, 2, 50);
        Assert::lengthBetween($lastName, 2, 50);
        Assert::minLength($password, 8);
        Assert::email($email);
        Assert::inArray($this->currency, DolarRatio::SUPPORTED_CURRENCIES);
    }
}
