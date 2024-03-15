<?php

declare(strict_types=1);

namespace Techno\Framework;

use Symfony\Component\HttpFoundation\Response;

interface HttpHandler
{
    public function __invoke(): Response;
}
