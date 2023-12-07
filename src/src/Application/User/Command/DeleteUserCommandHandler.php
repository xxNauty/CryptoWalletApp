<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Domain\Shared\Command\CommandHandlerInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Service\UserPasswordServiceInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordServiceInterface $passwordService,
        private UserSecurityServiceInterface $securityService
    ) {
    }

    public function __invoke(DeleteUserCommand $command): User
    {
        if (null === $user = $this->userRepository->find($command->id)) {
            throw new NotFoundHttpException('There is no user with given ID');
        }

        if ($user !== $this->securityService->getUser() && User::ROLE_ADMIN !== $this->securityService->getUser()->role) {
            throw new AccessDeniedException('It is not your account!');
        }

        if (!$this->passwordService->verifyPassword($user, $command->password)) {
            throw new AccessDeniedException('Given password is not correct');
        }

        $this->userRepository->remove($user);

        return $user;
    }
}
