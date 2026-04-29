<?php
namespace App\Controller;

abstract class BaseController
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $viewPath = __DIR__ . '/../../views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("View not found: {$view}");
        }

        require $viewPath;
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    protected function flashSuccess(string $message): void
    {
        $_SESSION['flash_success'] = $message;
    }

    protected function flashError(string $message): void
    {
        $_SESSION['flash_error'] = $message;
    }

    protected function flashInfo(string $message): void
    {
        $_SESSION['flash_info'] = $message;
    }

    /**
     * Get a flash message from session (and clear it)
     * Also handles old input and validation errors
     */
    protected function getFlash(string $key): ?array
    {
        $value = $_SESSION[$key] ?? null;
        unset($_SESSION[$key]);
        return $value;
    }

    protected function isValidId($id): bool
    {
        return is_numeric($id) && (int)$id > 0;
    }

    protected function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    protected function json($data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function notFound(string $message = "Resource not found"): void
    {
        http_response_code(404);
        echo "<h1>404 - Not Found</h1>";
        echo "<p>" . htmlspecialchars($message) . "</p>";
        exit;
    }

    protected function forbidden(string $message = "Access forbidden"): void
    {
        http_response_code(403);
        echo "<h1>403 - Forbidden</h1>";
        echo "<p>" . htmlspecialchars($message) . "</p>";
        exit;
    }

    protected function serverError(string $message = "Internal server error"): void
    {
        http_response_code(500);
        echo "<h1>500 - Server Error</h1>";
        echo "<p>" . htmlspecialchars($message) . "</p>";
        exit;
    }
}