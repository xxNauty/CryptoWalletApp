<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Domain\Shared\Command\CommandHandlerInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function __invoke(DeleteUserCommand $command): User
    {
        if (null === $user = $this->userRepository->find($command->id)) {
            throw new NotFoundHttpException('Nie znaleziono użytkownika o podanym ID');
        }

        $this->userRepository->remove($user);

        return $user;
    }
}
