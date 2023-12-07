<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Domain\DolarRatio\Model\DolarRatio;
use App\Domain\Shared\Command\CommandHandlerInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Service\UserPasswordServiceInterface;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;

readonly class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordServiceInterface $passwordService,
    ) {
    }

    public function __invoke(CreateUserCommand $command): User
    {
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        if (!in_array($command->currency, [DolarRatio::SUPPORTED_CURRENCIES, DolarRatio::DEFAULT_CURRENCY])) {
            throw new InvalidArgumentException('Given currency is not available');
=======
        if (!in_array($command->currency, array_merge(DolarRatio::SUPPORTED_CURRENCIES, [DolarRatio::DEFAULT_CURRENCY]))) {
            throw new InvalidArgumentException('Given currency is not available '.$command->currency);
>>>>>>> origin/develop
=======
        if (!in_array($command->currency, array_merge(DolarRatio::SUPPORTED_CURRENCIES, [DolarRatio::DEFAULT_CURRENCY]))) {
            throw new InvalidArgumentException('Given currency is not available '.$command->currency);
>>>>>>> origin/develop
=======
        if (!in_array($command->currency, array_merge(DolarRatio::SUPPORTED_CURRENCIES, [DolarRatio::DEFAULT_CURRENCY]))) {
            throw new InvalidArgumentException('Given currency is not available '.$command->currency);
>>>>>>> origin/develop
        }

        $user = new User(
            $command->email,
            $command->firstName,
            $command->lastName,
            $command->currency,
        );

        $this->passwordService->updatePassword($user, $command->password);

        $this->userRepository->save($user);

        return $user;
    }
}
