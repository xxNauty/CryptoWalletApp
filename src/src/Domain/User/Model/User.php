<?php

declare(strict_types=1);

namespace App\Domain\User\Model;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'user_base')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_PLAYER = 'ROLE_PLAYER';

    public const ALLOWED_ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_PLAYER,
    ];

    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    public readonly int $id;

    #[ORM\Column(type: Types::STRING, length: 50)]
    public string $role;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $password;

    public function __construct(
        #[ORM\Column(type: Types::STRING, length: 100, unique: true)]
        public string $email,

        #[ORM\Column(type: Types::STRING, length: 50)]
        public string $firstName,

        #[ORM\Column(type: Types::STRING, length: 50)]
        public string $lastName,
    ) {
        $this->role = self::ROLE_PLAYER;
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}