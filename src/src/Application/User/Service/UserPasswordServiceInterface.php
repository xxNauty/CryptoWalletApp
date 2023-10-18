<?php

declare(strict_types=1);

namespace App\Application\User\Service;

use App\Domain\User\Model\User;

interface UserPasswordServiceInterface
{
    public function updatePassword(User $user, ?string $plainPassword): void;
}
