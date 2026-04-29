<?php
namespace App\Routing;

/**
 * Represents a single route definition
 */
class Route
{
    private string $method;
    private string $pattern;
    private string $controller;
    private string $action;
    private ?string $name = null;

    public function __construct(string $method, string $pattern, string $controller, string $action)
    {
        $this->method = $method;
        $this->pattern = $pattern;
        $this->controller = $controller;
        $this->action = $action;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Convert pattern to regex and extract parameter names
     */
    public function toRegex(): array
    {
        $pattern = $this->pattern;
        $params = [];
        
        // Extract parameter names
        preg_match_all('/\{([^\}]+)\}/', $pattern, $matches);
        if (!empty($matches[1])) {
            $params = $matches[1];
        }

        // Convert pattern to regex
        $regex = preg_replace('/\{[^\}]+\}/', '([^/]+)', $pattern);
        $regex = "#^" . $regex . "$#";

        return ['regex' => $regex, 'params' => $params];
    }

    /**
     * Check if this route matches the given URI and method
     */
    public function matches(string $uri, string $method): bool
    {
        return $this->method === $method && preg_match($this->toRegex()['regex'], $uri);
    }

    /**
     * Extract parameters from URI based on route pattern
     */
    public function extractParams(string $uri): array
    {
        $routeData = $this->toRegex();
        $params = [];

        if (preg_match($routeData['regex'], $uri, $matches)) {
            array_shift($matches);
            foreach ($routeData['params'] as $index => $paramName) {
                $params[$paramName] = $matches[$index] ?? null;
            }
        }

        return $params;
    }
}
