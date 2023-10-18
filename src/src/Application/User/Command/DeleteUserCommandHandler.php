<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\Shared\Command\CommandHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        if (null === $user = $this->userRepository->find($command->id)) {
            throw new NotFoundHttpException('Nie znaleziono użytkownika o podanym ID');
        }

        $this->userRepository->remove($user);
    }
}
