<?php

declare(strict_types=1);

namespace Depth\Techno;

use Depth\Techno\Exceptions\EnvNotFoundException;
use Depth\Techno\Exceptions\RouteNotFoundException;
use Depth\Techno\Exceptions\RouterException;
use Depth\Techno\Exceptions\ServiceNotFoundException;
use M1\Env\Parser;
use ReflectionException;

final readonly class App
{
    private Container $container;

    /**
     * @throws EnvNotFoundException
     */
    public function __construct(
        string $env_path = __DIR__.'/.env',
        private string $router_path = __DIR__.'/routes.php',
    ) {
        error_reporting(0);

        $this->loadEnv($env_path);
        $this->container = new Container();
    }

    /**
     * @throws ServiceNotFoundException
     * @throws RouterException
     * @throws ReflectionException
     * @throws RouteNotFoundException
     */
    public function run(): void
    {
        if ($_ENV['DEBUG'] ?? false) {
            error_reporting(1);
        }

        /** @var Router $router */
        $router = $this->container->get(Router::class);
        $router->resolve($this->router_path)->send();
    }

    /**
     * @throws EnvNotFoundException
     */
    private function loadEnv(string $env_path): void
    {
        $contents = file_get_contents($env_path);

        if (false === $contents) {
            throw new EnvNotFoundException();
        }

        foreach (Parser::parse($contents) as $key => $value) {
            $_ENV[$key] = $value;
        }
    }
}
