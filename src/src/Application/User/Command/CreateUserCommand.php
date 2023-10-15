<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\Shared\Command\CommandInterface;
use Webmozart\Assert\Assert;

final class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public readonly string $email,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $password
    ) {
        Assert::lengthBetween($email, 5, 100);
        Assert::lengthBetween($firstName, 2, 50);
        Assert::lengthBetween($lastName, 2, 50);
        Assert::minLength($password, 8);
        Assert::email($email);
    }
}
