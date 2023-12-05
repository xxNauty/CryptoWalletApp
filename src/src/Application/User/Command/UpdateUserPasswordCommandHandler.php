<?php

namespace App\Application\User\Command;

use ApiPlatform\Symfony\Security\Exception\AccessDeniedException;
use App\Domain\Shared\Command\CommandHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Service\UserPasswordServiceInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;

readonly class UpdateUserPasswordCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserSecurityServiceInterface $securityService,
        private UserPasswordServiceInterface $passwordService
    ) {
    }

    public function __invoke(UpdateUserPasswordCommand $command): void
    {
        $user = $this->securityService->getUser();

        if (!$this->passwordService->verifyPassword($user, $command->oldPassword)) {
            throw new AccessDeniedException('Password incorrect');
        }

        $this->passwordService->updatePassword($user, $command->newPassword);

        $this->userRepository->save($user);
    }
}
