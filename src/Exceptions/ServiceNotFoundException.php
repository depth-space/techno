<?php

declare(strict_types=1);

namespace Techno\Framework\Exceptions;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

final class ServiceNotFoundException extends Exception implements NotFoundExceptionInterface {}
