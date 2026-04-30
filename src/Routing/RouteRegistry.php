<?php
namespace App\Routing;

/**
 * Central registry for all application routes
 * Supports declarative route registration and resource-based routing
 */
class RouteRegistry
{
    private array $routes = [];
    private array $namedRoutes = [];

    /**
     * Register a GET route
     */
    public function get(string $pattern, string $controller, string $action, ?string $name = null): self
    {
        return $this->register('GET', $pattern, $controller, $action, $name);
    }

    /**
     * Register a POST route
     */
    public function post(string $pattern, string $controller, string $action, ?string $name = null): self
    {
        return $this->register('POST', $pattern, $controller, $action, $name);
    }

    /**
     * Register a PUT route
     */
    public function put(string $pattern, string $controller, string $action, ?string $name = null): self
    {
        return $this->register('PUT', $pattern, $controller, $action, $name);
    }

    /**
     * Register a DELETE route
     */
    public function delete(string $pattern, string $controller, string $action, ?string $name = null): self
    {
        return $this->register('DELETE', $pattern, $controller, $action, $name);
    }

    /**
     * Register a resource with standard CRUD routes
     * Maps: index, create, store, show, edit, update, delete
     */
    public function resource(string $resource, string $controller): self
    {
        $resourcePath = strtolower($resource);
        
        // GET /resource - list all
        $this->get("/{$resourcePath}", $controller, 'index', "{$resource}.index");
        
        // GET /resource/create - show create form
        $this->get("/{$resourcePath}/create", $controller, 'create', "{$resource}.create");
        
        // POST /resource - store new
        $this->post("/{$resourcePath}", $controller, 'store', "{$resource}.store");
        
        // GET /resource/{id} - show single
        $this->get("/{$resourcePath}/{id}", $controller, 'show', "{$resource}.show");
        
        // GET /resource/{id}/edit - show edit form
        $this->get("/{$resourcePath}/{id}/edit", $controller, 'edit', "{$resource}.edit");
        
        // POST /resource/{id} - update (alternative to PUT)
        $this->post("/{$resourcePath}/{id}", $controller, 'update', "{$resource}.update");
        
        // GET /resource/{id}/delete - show delete confirmation
        $this->get("/{$resourcePath}/{id}/delete", $controller, 'confirmDelete', "{$resource}.confirmDelete");

        // Fixed: Use 'delete' method instead of 'destroy' to match controller
        $this->delete("/{$resourcePath}/{id}", $controller, 'delete', "{$resource}.delete"); // Changed from 'destroy'
        
        return $this;
    }

    /**
     * Internal method to register a route
     */
    private function register(string $method, string $pattern, string $controller, string $action, ?string $name = null): self
    {
        $route = new Route($method, $pattern, $controller, $action);
        
        if ($name) {
            $route->setName($name);
            $this->namedRoutes[$name] = $route;
        }

        $this->routes[] = $route;
        return $this;
    }

    /**
     * Get all registered routes
     */
    public function all(): array
    {
        return $this->routes;
    }

    /**
     * Get a route by name
     */
    public function getByName(string $name): ?Route
    {
        return $this->namedRoutes[$name] ?? null;
    }

    /**
     * Find a matching route for the given URI and method
     */
    public function match(string $uri, string $method): ?Route
    {
        foreach ($this->routes as $route) {
            if ($route->matches($uri, $method)) {
                return $route;
            }
        }
        return null;
    }
}
