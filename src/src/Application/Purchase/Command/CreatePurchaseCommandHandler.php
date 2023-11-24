<?php

namespace App\Application\Purchase\Command;

use App\Domain\Shared\Command\CommandHandlerInterface;

class CreatePurchaseCommandHandler implements CommandHandlerInterface
{
    public function __construct()
    {
    }

    public function __invoke(CreatePurchaseCommand $command)
    {
        // TODO: Implement __invoke() method.
    }
}