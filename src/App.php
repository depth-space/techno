<?php

declare(strict_types=1);

namespace Techno\Framework;

use M1\Env\Parser;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Techno\Framework\Exceptions\RouteNotFoundException;

final readonly class App
{
    private Router $router;
    private Container $container;

    public function __construct(string $env_path, string $router_path)
    {
        error_reporting(0);

        $this->loadEnv($env_path);
        $this->container = new Container();
        $this->router = new Router($router_path);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws RouteNotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function run(): void
    {
        if ($_ENV['DEBUG'] ?? false) {
            error_reporting(1);
        }

        $this->router->resolve($this->container)->send();
    }

    private function loadEnv(string $env_path): void
    {
        foreach (Parser::parse(file_get_contents($env_path)) as $key => $value) {
            $_ENV[$key] = $value;
        }
    }
}
