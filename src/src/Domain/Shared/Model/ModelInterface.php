<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model;

interface ModelInterface
{
    public function getResource(): string;
}
