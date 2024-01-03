<?php

declare(strict_types=1);

namespace Techno\Framework;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Techno\Framework\Exceptions\RouteNotFoundException;

use function array_key_exists;

final readonly class Router
{
    /** @var array<string, class-string> */
    private array $routes;

    public function __construct(string $router_path)
    {
        $this->routes = require $router_path;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws RouteNotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function resolve(ContainerInterface $container): Response
    {
        $link = explode('/', $_SERVER['REQUEST_URI'] ?? '');
        $link = explode('?', $link[1]);
        $link = "{$_SERVER['REQUEST_METHOD']} /{$link[0]}";

        if (!array_key_exists($link, $this->routes)) {
            throw new RouteNotFoundException();
        }

        $handler = $container->get($this->routes[$link]);

        return $handler($container);
    }
}
