<?php

declare(strict_types=1);

namespace Techno\Framework;

use Symfony\Component\HttpFoundation\Response;
use Techno\Framework\Exceptions\RouteNotFoundException;
use Techno\Framework\Exceptions\RouterException;

use function array_key_exists;

final class Router
{
    /** @var string[] */
    public array $path;

    /** @var array<string, mixed> */
    private array $routes;

    public function __construct(
        private Container $container,
    ) {
        $this->path = explode(
            '/',
            trim(explode('?', $_SERVER['REQUEST_URI'] ?? '')[0], '/'),
        );
    }

    public function loadRoutes(string $router_path): void
    {
        $this->routes = array_merge_recursive(require $router_path);
    }

    public function resolve(): Response
    {
        $route = $this->routes;

        foreach ([$_SERVER['REQUEST_METHOD'], ...$this->path] as $path) {
            if (array_key_exists($path, $route)) {
                $route = $route[$path];

                continue;
            }

            if (array_key_exists('%', $route)) {
                $route = $route['%'];

                continue;
            }

            throw new RouteNotFoundException();
        }

        $handler = $this->container->get($route);

        if (!$handler instanceof HttpHandler) {
            throw new RouterException('Cannot use '.$handler::class.' as HttpHandler');
        }

        return $handler();
    }
}
