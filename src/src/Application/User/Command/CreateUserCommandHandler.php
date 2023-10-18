<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\Shared\Command\CommandHandlerInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\User\Service\UserPasswordService;

class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPasswordService $passwordService
    ) {
    }

    public function __invoke(CreateUserCommand $command): User
    {
        $user = new User(
            $command->email,
            $command->firstName,
            $command->lastName,
        );

        $this->passwordService->updatePassword($user, $command->password);

        $this->userRepository->save($user);

        return $user;
    }
}
