<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\ApiPlatform\Resource;

interface ResourceInterface
{
    public static function fromModel(object $model, array $excludedVars = []): object;
}
