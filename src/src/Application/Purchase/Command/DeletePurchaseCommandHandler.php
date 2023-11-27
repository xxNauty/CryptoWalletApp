<?php

namespace App\Application\Purchase\Command;

use App\Domain\Shared\Command\CommandHandlerInterface;

class DeletePurchaseCommandHandler implements CommandHandlerInterface
{
    public function __construct()
    {
    }

    public function __invoke(DeletePurchaseCommand $command)
    {
        // TODO: Implement __invoke() method.
    }
}
