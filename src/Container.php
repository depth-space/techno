<?php

declare(strict_types=1);

namespace Depth\Techno;

use Depth\Techno\Exceptions\ServiceNotFoundException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;

use function array_key_exists;

final class Container implements ContainerInterface
{
    /**
     * @var array<class-string, object>
     */
    private array $services = [];

    /**
     * @param class-string $id
     */
    public function get(string $id): object
    {
        $item = $this->resolve($id);
        if (!$item instanceof ReflectionClass) {
            return $item;
        }

        return $this->getInstance($item);
    }

    /**
     * @param class-string $id
     */
    public function has(string $id): bool
    {
        try {
            $item = $this->resolve($id);
        } catch (ServiceNotFoundException) {
            return false;
        }

        if ($item instanceof ReflectionClass) {
            return $item->isInstantiable();
        }

        return true;
    }

    /**
     * @param class-string $id
     */
    public function set(string $id, object $value): self
    {
        $this->services[$id] = $value;

        return $this;
    }

    /**
     * @param class-string $id
     */
    private function resolve(string $id): object
    {
        if (array_key_exists($id, $this->services)) {
            return $this->services[$id];
        }

        if (self::class === $id) {
            return $this;
        }

        try {
            return new ReflectionClass($id);
            // @phpstan-ignore-next-line
        } catch (ReflectionException $e) {
            throw new ServiceNotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param ReflectionClass<object> $item
     */
    private function getInstance(ReflectionClass $item): object
    {
        $params = [];

        foreach ($item->getConstructor()?->getParameters() ?? [] as $param) {
            $type = $param->getType();
            if ($type instanceof ReflectionNamedType) {
                // @phpstan-ignore-next-line
                $params[] = $this->get($type->getName());
            }
        }

        return $item->newInstanceArgs($params);
    }
}
