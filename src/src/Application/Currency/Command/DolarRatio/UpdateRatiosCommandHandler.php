<?php

declare(strict_types=1);

namespace App\Application\Currency\Command\DolarRatio;

use App\Domain\Currency\Service\DolarRatioManagerInterface;
use App\Domain\Shared\Command\CommandHandlerInterface;

readonly class UpdateRatiosCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DolarRatioManagerInterface $dolarRatioManager
    ) {
    }

    public function __invoke(UpdateRatiosCommand $command): void
    {
        $this->dolarRatioManager->updateAll();
    }
}
