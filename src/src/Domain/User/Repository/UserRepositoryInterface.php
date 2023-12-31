<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Model\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function remove(User $user): void;

    public function find(int $id): ?User;

    public function findByEmail(?string $email): ?User;

    public function getAll(): ?array;
}
