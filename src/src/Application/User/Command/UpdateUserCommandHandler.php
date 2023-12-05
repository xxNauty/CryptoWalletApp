<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use ApiPlatform\Symfony\Security\Exception\AccessDeniedException;
use App\Domain\Shared\Command\CommandHandlerInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Service\UserPasswordServiceInterface;
use App\Domain\User\Service\UserSecurityServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class UpdateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordServiceInterface $passwordService,
        private UserSecurityServiceInterface $securityService
    ) {
    }

    public function __invoke(UpdateUserCommand $command): User
    {
        if (null === $user = $this->userRepository->find($command->id)) {
            throw new NotFoundHttpException('There is no user with given ID');
        }

        if ($user !== $this->securityService->getUser()) {
            throw new AccessDeniedException('It is not your account!');
        }

        if (!$this->passwordService->verifyPassword($user, $command->password)) {
            throw new AccessDeniedException('Given password is not correct');
        }

        $user->email = $command->email ?? $user->email;
        $user->firstName = $command->firstName ?? $user->firstName;
        $user->lastName = $command->lastName ?? $user->lastName;
        $this->passwordService->updatePassword($user, $command->password);
        $user->currency = $command->currency ?? $user->currency;

        $this->userRepository->save($user);

        return $user;
    }
}
