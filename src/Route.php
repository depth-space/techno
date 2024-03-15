<?php

declare(strict_types=1);

namespace Techno\Framework;

final readonly class Route
{
    /** @return array<string, mixed> */
    public static function __invoke(string $method, string $path): array
    {
        return [$method => explode('/', $path)];
    }
}
