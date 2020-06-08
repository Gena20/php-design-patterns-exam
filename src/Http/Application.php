<?php

namespace App\Http;

use App\Routes\Config;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Application.​​
 */
class Application
{
    private static ?self $instance = null;
    private ?Config $routeConfig = null;

    /**
     * @param Config|null $config
     *
     * @return Application
     */
    public static function getInstance(Config $config): self
    {
        if (static::$instance === null)
            static::$instance = new static();

        static::$instance->routeConfig = $config ?? null;

        return static::$instance;
    }

    public function dispose(): void
    {
        self::$instance = null;
        $this->routeConfig = null;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        if ($this->routeConfig === null)
            throw new \RuntimeException('Routes config is not defined');

        if (!$this->routeConfig->offsetExists($request->getPathInfo()))
            return new Response('Page not found', Response::HTTP_NOT_FOUND);

        $callback = $this->routeConfig->offsetGet($request->getPathInfo());
        return $callback($request);
    }

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}
}
