<?php

declare(strict_types=1);

namespace App\Domain\User\Model;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'user_base')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    public readonly int $id;

    public function __construct(
        #[ORM\Column(type: Types::STRING, length: 100)]
        public string $email,

        #[ORM\Column(type: Types::STRING, length: 50)]
        public string $firstName,

        #[ORM\Column(type: Types::STRING, length: 50)]
        public string $lastName,

        #[ORM\Column(type: Types::STRING, length: 255)]
        public string $password,
    ) {}
}
