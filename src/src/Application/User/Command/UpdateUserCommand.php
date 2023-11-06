<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Domain\Shared\Command\CommandInterface;
use Webmozart\Assert\Assert;

class UpdateUserCommand implements CommandInterface
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $email = null,
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?string $password = null,
    ) {
        Assert::nullOrLengthBetween($email, 5, 100);
        Assert::nullOrLengthBetween($firstName, 2, 50);
        Assert::nullOrLengthBetween($lastName, 2, 50);
        Assert::nullOrMinLength($password, 8);
        Assert::nullOrEmail($email);
    }
}
