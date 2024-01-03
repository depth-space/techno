<?php

declare(strict_types=1);

namespace Techno\Framework;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;
use Techno\Framework\Exceptions\ServiceNotFoundException;

use function is_callable;

final class Container implements ContainerInterface
{
    private array $services = [];

    /**
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     * @throws ContainerExceptionInterface
     * @throws ServiceNotFoundException
     */
    public function get(string $id)
    {
        $item = $this->resolve($id);
        if (!$item instanceof ReflectionClass) {
            return $item;
        }

        return $this->getInstance($item);
    }

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

        return isset($item);
    }

    public function set(string $key, mixed $value): self
    {
        $this->services[$key] = $value;

        return $this;
    }

    /**
     * @throws ServiceNotFoundException
     */
    private function resolve(string $id)
    {
        try {
            $name = $id;
            if (isset($this->services[$id])) {
                $name = $this->services[$id];
                if (is_callable($name)) {
                    return $name();
                }
            }

            return new ReflectionClass($name);
        } catch (ReflectionException $e) {
            throw new ServiceNotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws ReflectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getInstance(ReflectionClass $item)
    {
        $constructor = $item->getConstructor();
        if (null === $constructor || 0 === $constructor->getNumberOfRequiredParameters()) {
            return $item->newInstance();
        }

        $params = [];
        foreach ($constructor->getParameters() as $param) {
            if ($type = $param->getType()) {
                $params[] = $this->get($type->getName());
            }
        }

        return $item->newInstanceArgs($params);
    }
}
