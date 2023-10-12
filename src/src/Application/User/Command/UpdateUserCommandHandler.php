<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\Shared\Command\CommandHandlerInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;

final class UpdateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(UpdateUserCommand $command): User
    {
        $user = $this->userRepository->find($command->id);

        $user->email = $command->email ?? $user->email;
        $user->firstName = $command->firstName ?? $user->firstName;
        $user->lastName = $command->lastName ?? $user->lastName;

        $this->userRepository->save($user);

        return $user;
    }
}
