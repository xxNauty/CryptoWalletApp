<?php

namespace App\Domain\User\Service;

use App\Domain\User\Model\User;

interface UserSecurityServiceInterface
{
    public function getUser(): ?User;

    public function isLogged(): bool;
}
