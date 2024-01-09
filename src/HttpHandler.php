<?php

declare(strict_types=1);

namespace Depth\Techno;

use Symfony\Component\HttpFoundation\Response;

interface HttpHandler
{
    public function __invoke(): Response;
}
