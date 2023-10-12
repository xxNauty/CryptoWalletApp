<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Model\User;
use App\Domain\Shared\Repository\RepositoryInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @extends RepositoryInterface<User>
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    public function save(User $user): void;

    public function remove(User $user): void;

    public function find(int $id): ?User;

    public function withFirstName(string $firstName): static;
}
