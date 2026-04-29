<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Routing\RouteRegistry;
use App\Routing\Dispatcher;
use App\Routing\Routes;

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize database connection globally
try {
    $config = require __DIR__ . '/../config/app.php';
    $GLOBALS['pdo'] = new PDO(
        $config['db']['dsn'],
        $config['db']['user'],
        $config['db']['pass'],
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (Exception $e) {
    http_response_code(500);
    die("Database connection failed: " . $e->getMessage());
}

try {
    // Create route registry and register all routes
    $routeRegistry = new RouteRegistry();
    Routes::register($routeRegistry);

    // Dispatch the incoming request
    $dispatcher = new Dispatcher($routeRegistry);
    $dispatcher->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (Exception $e) {
    http_response_code(500);
    echo "Internal Server Error: " . htmlspecialchars($e->getMessage());
}