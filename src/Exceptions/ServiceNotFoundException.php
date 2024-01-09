<?php

declare(strict_types=1);

namespace Depth\Techno\Exceptions;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

final class ServiceNotFoundException extends Exception implements NotFoundExceptionInterface {}
