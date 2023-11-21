<?php

declare(strict_types=1);

namespace App\Application\Currency\Command\DollarRatio;

use App\Domain\Currency\Service\DollarRatioManagerInterface;
use App\Domain\Shared\Command\CommandHandlerInterface;

readonly class UpdateRatiosCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DollarRatioManagerInterface $dollarRatioManager
    ) {
    }

    public function __invoke(UpdateRatiosCommand $command): void
    {
        $this->dollarRatioManager->updateAll();
    }
}
