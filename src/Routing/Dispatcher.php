<?php
namespace App\Routing;

use Exception;
use ReflectionMethod;

/**
 * Central route dispatcher
 * Matches incoming requests to routes and dispatches to controllers
 */
class Dispatcher
{
    private RouteRegistry $registry;

    public function __construct(RouteRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * Dispatch an incoming request
     */

    public function dispatch(string $uri, string $method): void
    {
    // Parse the URL to remove query strings and normalize
    $uri = parse_url($uri, PHP_URL_PATH);
    $uri = rtrim($uri, '/') ?: '/';

    // Start session
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Find matching route
    $route = $this->registry->match($uri, $method);
    if ($route === null) {
        // Try alternative HTTP methods for DELETE (since forms typically use POST)
        if ($method === 'POST' && isset($_POST['_method'])) {
            $altMethod = strtoupper($_POST['_method']);
            $route = $this->registry->match($uri, $altMethod);
        }
        
        if ($route === null) {
            $this->handle404();
            return;
        }
    }
    try {
        $this->executeRoute($route, $uri);
    } catch (Exception $e) {
        $this->handle500($e);
    }
    }

    /**
     * Execute a matched route
     */
    private function executeRoute(Route $route, string $uri): void
    {
        $controllerClass = $route->getController();
        $actionMethod = $route->getAction();

        // Verify controller and action exist
        if (!class_exists($controllerClass)) {
            throw new Exception("Controller class not found: {$controllerClass}");
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $actionMethod)) {
            throw new Exception("Action method not found: {$controllerClass}@{$actionMethod}");
        }

        // Extract route parameters
        $params = $route->extractParams($uri);

        // Call the action with extracted parameters
        $reflection = new ReflectionMethod($controller, $actionMethod);
        $args = [];

        foreach ($reflection->getParameters() as $parameter) {
            $paramName = $parameter->getName();
            
            if (isset($params[$paramName])) {
                $args[] = $params[$paramName];
            } elseif ($parameter->isDefaultValueAvailable()) {
                $args[] = $parameter->getDefaultValue();
            } else {
                $args[] = null;
            }
        }

        call_user_func_array([$controller, $actionMethod], $args);
    }

    /**
     * Handle 404 Not Found
     */
    private function handle404(): void
    {
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1>";
        echo "<p>The requested resource could not be found.</p>";
    }

    /**
     * Handle 500 Server Error
     */
    private function handle500(Exception $e): void
    {
        http_response_code(500);
        echo "<h1>500 - Internal Server Error</h1>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
        
        // Log the error (optional)
        error_log($e->getMessage());
    }
}
