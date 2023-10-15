<?php

namespace App\Infrastructure\User\Service;

use App\Application\User\Service\UserPasswordServiceInterface;
use App\Domain\User\Model\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPasswordService implements UserPasswordServiceInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function updatePassword(User $user, ?string $plainPassword): void
    {
        if($plainPassword != null){
            $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));
        }
    }
}