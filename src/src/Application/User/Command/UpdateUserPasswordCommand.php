<?php

namespace App\Application\User\Command;

use App\Domain\Shared\Command\CommandInterface;
use Webmozart\Assert\Assert;

readonly class UpdateUserPasswordCommand implements CommandInterface
{
    public function __construct(
        public string $oldPassword,
        public string $newPassword,
    ) {
        Assert::minLength($this->newPassword, 8);
    }
}
