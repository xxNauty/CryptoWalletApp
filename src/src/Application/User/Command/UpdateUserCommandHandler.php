<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\Shared\Command\CommandHandlerInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\User\Service\UserPasswordService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPasswordService $passwordService
    ) {
    }

    public function __invoke(UpdateUserCommand $command): User
    {
        $user = $this->userRepository->find($command->id);

        if (null === $user) {
            throw new NotFoundHttpException('Nie znaleziono użytkownika o podanym ID');
        }

        $user->email = $command->email ?? $user->email;
        $user->firstName = $command->firstName ?? $user->firstName;
        $user->lastName = $command->lastName ?? $user->lastName;
        $this->passwordService->updatePassword($user, $command->password);

        $this->userRepository->save($user);

        return $user;
    }
}
