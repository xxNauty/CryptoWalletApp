<?php

namespace App\Infrastructure\User\Service;

use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;
use Symfony\Component\Security\Core\Security;

readonly class UserSecurityService implements UserSecurityServiceInterface
{
    public function __construct(
        private Security $security,
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function getUser(): ?User
    {
        return $this->userRepository->findByEmail(
            $this->security->getUser()?->getUserIdentifier()
        );
    }

    public function isLogged(): bool
    {
        if (is_null($this->security->getUser())) {
            return true;
        }

        return false;
    }
}
