<?php

namespace App\Routes;

class Config implements \ArrayAccess, \IteratorAggregate
{
    /**
     * @var array|callable[]
     */
    protected array $routesConfig;

    /**
     * @param array $routes
     */
    public function __construct(array $routes = [])
    {
        $this->routesConfig = $routes;
    }

    /**
     * @param array $configuration
     *
     * @return static
     */
    public static function configure(array $configuration): self
    {
        $instance = new static();

        foreach ($configuration as $key => $value) {
            if (\is_callable($value)) {
                $instance->offsetSet($key, $value);
            }
        }

        return $instance;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->routesConfig);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset): bool
    {
        return \array_key_exists($offset, $this->routesConfig);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        return $this->routesConfig[$offset] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value): self
    {
        $this->routesConfig[$offset] = $value;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset): self
    {
        unset($this->routesConfig[$offset]);

        return $this;
    }
}
