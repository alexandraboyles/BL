# MVC Routing Implementation Guide

## Overview

This is a modern, scalable routing system for handling many objects/resources in your MVC application. It replaces the previous individual router classes with a centralized, declarative approach.

## Key Components

### 1. **Route** (`src/Routing/Route.php`)
Represents a single route definition with:
- HTTP method (GET, POST, PUT, DELETE)
- URI pattern (supports parameters like `/resource/{id}`)
- Controller class name
- Action method name
- Optional route name for URL generation

**Features:**
- Pattern-to-regex conversion
- Parameter extraction from URIs
- Route matching

### 2. **RouteRegistry** (`src/Routing/RouteRegistry.php`)
Central registry for all application routes. Provides:
- `get()`, `post()`, `put()`, `delete()` - Register individual routes
- `resource()` - Auto-register standard RESTful CRUD routes
- `match()` - Find matching route for a request
- `getByName()` - Get route by name for URL generation

**Example:**
```php
$router->get('/home', 'App\Controller\HomeController', 'index', 'home');
$router->resource('Product', 'App\Controller\ProductController');
```

### 3. **Dispatcher** (`src/Routing/Dispatcher.php`)
Handles request dispatching:
- Matches incoming URIs to routes
- Instantiates controllers
- Calls appropriate action methods
- Manages error handling (404, 500)

### 4. **Routes** (`src/Routing/Routes.php`)
Central configuration file where you register all application routes. This is the single place to define your entire routing structure.

## RESTful Resource Routing

The `resource()` method automatically creates these standard routes:

| Method | Route | Action | Name |
|--------|-------|--------|------|
| GET | /resource | index() | resource.index |
| GET | /resource/create | create() | resource.create |
| POST | /resource | store() | resource.store |
| GET | /resource/{id} | show() | resource.show |
| GET | /resource/{id}/edit | edit() | resource.edit |
| POST | /resource/{id} | update() | resource.update |
| GET | /resource/{id}/delete | confirmDelete() | resource.confirmDelete |

**Usage:**
```php
// In Routes::register()
$router->resource('Address', 'App\Controller\AddressController');
$router->resource('Product', 'App\Controller\ProductController');
$router->resource('Invoice', 'App\Controller\InvoiceController');
```

## Adding New Resources

### Step 1: Create Controller
Create a controller with standard CRUD methods:

```php
namespace App\Controller;

class ProductController
{
    public function index() { /* List all products */ }
    public function create() { /* Show create form */ }
    public function store($data) { /* Save new product */ }
    public function show($id) { /* Show single product */ }
    public function edit($id) { /* Show edit form */ }
    public function update($id) { /* Save updated product */ }
    public function confirmDelete($id) { /* Show delete confirmation */ }
    public function delete($id) { /* Delete product */ }
}
```

### Step 2: Register in Routes.php
```php
public static function register(RouteRegistry $router): void
{
    // ... existing routes ...
    
    $router->resource('Product', 'App\Controller\ProductController');
}
```

That's it! All routes are automatically created.

## Custom Routes

For non-RESTful endpoints:

```php
// In Routes::register()
$router->post('/addresses/bulk-upload', 'App\Controller\AddressController', 'bulkUpload', 'addresses.bulk-upload');
$router->get('/reports/summary', 'App\Controller\ReportController', 'summary', 'reports.summary');
$router->get('/api/products/{id}', 'App\Controller\ProductController', 'apiShow', 'api.product.show');
```

## Route Parameters

Routes support parameters in curly braces. Parameters are extracted and passed to controller methods:

```php
// Route definition
$router->get('/products/{id}', 'App\Controller\ProductController', 'show');

// URL: /products/42
// Calls: ProductController->show(42)

public function show($id) { /* $id = '42' */ }
```

## Flow Diagram

```
HTTP Request
    ↓
public/index.php
    ↓
Load Routes (src/Routing/Routes.php)
    ↓
Create Dispatcher with RouteRegistry
    ↓
Dispatcher->dispatch()
    ↓
RouteRegistry->match($uri, $method)
    ↓
Route found? ───NO──→ Handle 404
    ↓ YES
Extract parameters
    ↓
Instantiate Controller
    ↓
Call Action Method with parameters
    ↓
Render View / Return Response
```

## Best Practices

### 1. **Naming Conventions**
- Resources should be singular in controller names: `ProductController`, `InvoiceController`
- Use lowercase for route patterns: `/products`, `/invoices`

### 2. **Controller Method Signatures**
```php
// For routes without parameters
public function index() { }

// For routes with parameters
public function show($id) { }
public function edit($id) { }
public function update($id) { }

// For POST actions receiving form data
public function store($data) { }

// Parameter order doesn't matter, names are matched
public function custom($id, $type) { } // GET /resource/{id}/{type}
```

### 3. **Organize Routes**
Group related routes in Routes.php:

```php
public static function register(RouteRegistry $router): void
{
    // Static routes
    $router->get('/', 'App\Controller\HomeController', 'index', 'home');
    
    // Address-related
    $router->resource('Address', 'App\Controller\AddressController');
    
    // Contact-related
    $router->resource('Contact', 'App\Controller\ContactController');
    
    // API routes
    $router->get('/api/addresses', 'App\Controller\AddressController', 'apiIndex', 'api.addresses.index');
}
```

### 4. **Error Handling**
The Dispatcher handles:
- **404**: Route not found
- **500**: Controller/action doesn't exist, or exception thrown in controller

## Migration from Old Routing

### Old Approach (Don't Use Anymore)
```php
// public/index.php - had individual routers
$addressRouter = new AddressRouter();
$addressRouter->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
```

### New Approach
```php
// public/index.php - single centralized system
$routeRegistry = new RouteRegistry();
Routes::register($routeRegistry);
$dispatcher = new Dispatcher($routeRegistry);
$dispatcher->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
```

## Example: Full Resource Setup

```php
// 1. Create Controller (src/Controller/InvoiceController.php)
namespace App\Controller;

class InvoiceController
{
    private $service;
    
    public function __construct()
    {
        $this->service = new InvoiceService();
    }
    
    public function index()
    {
        $invoices = $this->service->getAll();
        require __DIR__ . '/../../views/invoice/index.php';
    }
    
    public function show($id)
    {
        $invoice = $this->service->getById((int)$id);
        require __DIR__ . '/../../views/invoice/view.php';
    }
    
    // ... other CRUD methods
}

// 2. Register in Routes.php
public static function register(RouteRegistry $router): void
{
    $router->resource('Invoice', 'App\Controller\InvoiceController');
}

// 3. URLs automatically available:
// GET  /invoice              → index()
// GET  /invoice/create       → create()
// POST /invoice              → store()
// GET  /invoice/42           → show(42)
// GET  /invoice/42/edit      → edit(42)
// POST /invoice/42           → update(42)
// GET  /invoice/42/delete    → confirmDelete(42)
```

## Troubleshooting

| Issue | Solution |
|-------|----------|
| 404 on all routes | Check Routes.php is properly registering resources |
| Controller not found | Verify namespace and class name in Routes.php |
| Method not found | Ensure controller has all required CRUD methods |
| Parameters not passed | Check method parameter names match route pattern names |

## Future Enhancements

- Middleware support
- Route groups with prefix
- URL generation helper functions
- Route model binding
- Multiple HTTP methods per route
