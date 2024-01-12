<?php

declare(strict_types=1);

namespace Depth\Techno;

use Depth\Techno\Exceptions\RouteNotFoundException;
use Depth\Techno\Exceptions\RouterException;
use Depth\Techno\Exceptions\ServiceNotFoundException;
use ReflectionException;
use Symfony\Component\HttpFoundation\Response;

use function array_key_exists;

final readonly class Router
{
    /** @var string[] */
    public array $path;

    public function __construct(
        private Container $container,
    ) {
        $this->path = explode(
            '/',
            trim(explode('?', $_SERVER['REQUEST_URI'] ?? '')[0], '/'),
        );
    }

    /**
     * @throws ServiceNotFoundException
     * @throws RouterException
     * @throws ReflectionException
     * @throws RouteNotFoundException
     */
    public function resolve(string $router_path): Response
    {
        /** @var array<string, class-string> $router_path */
        $routes = require $router_path;

        $link = "{$_SERVER['REQUEST_METHOD']} /{$this->path[0]}";

        if (!array_key_exists($link, $routes)) {
            throw new RouteNotFoundException();
        }

        $handler = $this->container->get($routes[$link]);

        if (!$handler instanceof HttpHandler) {
            throw new RouterException('Cannot use '.$handler::class.' as HttpHandler');
        }

        return $handler();
    }
}
