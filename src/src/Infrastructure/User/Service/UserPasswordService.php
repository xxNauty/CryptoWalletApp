<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Service;

use App\Application\User\Service\UserPasswordServiceInterface;
use App\Domain\User\Model\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPasswordService implements UserPasswordServiceInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function updatePassword(User $user, ?string $plainPassword): void
    {
        if (null != $plainPassword) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));
        }
    }
}
