<?php

declare(strict_types=1);

namespace Depth\Techno;

use Depth\Techno\Exceptions\RouteNotFoundException;
use Depth\Techno\Exceptions\RouterException;
use Symfony\Component\HttpFoundation\Response;

use function array_key_exists;

final readonly class Router
{
    /** @var string[] */
    public array $path;

    /** @var array<string, class-string> */
    private array $routes;

    public function __construct(string $router_path)
    {
        $this->routes = require $router_path;
        $this->path = explode('/', trim(explode('?', $_SERVER['REQUEST_URI'] ?? '')[0], '/'));
    }

    public function resolve(Container $container): Response
    {
        $link = "{$_SERVER['REQUEST_METHOD']} /{$this->path[0]}";

        if (!array_key_exists($link, $this->routes)) {
            throw new RouteNotFoundException();
        }

        $handler = $container->get($this->routes[$link]);

        if (!$handler instanceof HttpHandler) {
            throw new RouterException('Cannot use '.$handler::class.' as HttpHandler');
        }

        return $handler();
    }
}
