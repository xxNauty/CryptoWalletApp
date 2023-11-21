<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Service;

use App\Domain\User\Model\User;
use App\Domain\User\Service\UserPasswordServiceInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserPasswordService implements UserPasswordServiceInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function updatePassword(User $user, ?string $plainPassword): void
    {
        if (null != $plainPassword) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));
        }
    }
}
