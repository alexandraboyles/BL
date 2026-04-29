# MVC Routing Quick Reference

## Quick Start: Adding a New Resource

### 1. Create Controller
```php
// src/Controller/ProductController.php
namespace App\Controller;

use App\Service\ProductService;
use App\Validation\ProductValidator;

class ProductController extends BaseController
{
    private ProductService $service;
    private ProductValidator $validator;

    public function __construct()
    {
        $this->service = new ProductService();
        $this->validator = new ProductValidator();
    }

    public function index()
    {
        $products = $this->service->getAll();
        $this->render('product/index', ['products' => $products]);
    }

    public function show($id)
    {
        $product = $this->service->getById((int)$id);
        if (!$product) {
            $this->notFound("Product not found");
        }
        $this->render('product/view', ['product' => $product]);
    }

    public function create()
    {
        $this->render('product/create');
    }

    public function store($data)
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            $_SESSION['create_errors'] = $errors;
            $this->redirect('/product/create');
        }
        
        $this->service->create($data);
        $this->flashSuccess("Product created");
        $this->redirect('/product');
    }

    public function edit($id)
    {
        $product = $this->service->getById((int)$id);
        if (!$product) {
            $this->notFound("Product not found");
        }
        $this->render('product/edit', ['product' => $product]);
    }

    public function update($id)
    {
        $this->service->update((int)$id, $_POST);
        $this->flashSuccess("Product updated");
        $this->redirect('/product');
    }

    public function confirmDelete($id)
    {
        $product = $this->service->getById((int)$id);
        if (!$product) {
            $this->notFound();
        }
        $this->render('product/delete', ['product' => $product]);
    }

    public function delete($id)
    {
        $this->service->delete((int)$id);
        $this->flashSuccess("Product deleted");
        $this->redirect('/product');
    }
}
```

### 2. Register in Routes
```php
// src/Routing/Routes.php
public static function register(RouteRegistry $router): void
{
    $router->get('/', 'App\Controller\HomeController', 'index', 'home');
    $router->resource('Product', 'App\Controller\ProductController');
}
```

### 3. Create Views
```
views/
└── product/
    ├── index.php      (List all products)
    ├── create.php     (Create form)
    ├── view.php       (Single product)
    ├── edit.php       (Edit form)
    └── delete.php     (Delete confirmation)
```

**That's it!** These URLs are now available:
- `GET  /product` → index
- `GET  /product/create` → create
- `POST /product` → store
- `GET  /product/42` → show
- `GET  /product/42/edit` → edit
- `POST /product/42` → update
- `GET  /product/42/delete` → confirmDelete

## BaseController Helpers

### Rendering Views
```php
// views/products/index.php has access to $products variable
$this->render('product/index', ['products' => $products]);
```

### Redirecting
```php
$this->redirect('/product');
$this->redirect('/product/create');
```

### Flash Messages
```php
$this->flashSuccess("Item saved successfully");
$this->flashError("Something went wrong");
$this->flashInfo("Please review");

// In view:
<?php if ($msg = $this->getFlash('success')): ?>
    <div class="alert alert-success"><?= $msg ?></div>
<?php endif; ?>
```

### Error Responses
```php
$this->notFound("Item not found");
$this->forbidden("You don't have permission");
$this->serverError("Something went wrong");
```

### JSON Responses
```php
$this->json(['success' => true, 'data' => $products]);
$this->json(['error' => 'Not found'], 404);
```

### Utilities
```php
if ($this->isValidId($id)) { /* ... */ }
if ($this->isAjax()) { /* ... */ }
```

## Common Patterns

### Pattern: Auto-increment Resources
```php
// Routes.php
$router->resource('Address', 'App\Controller\AddressController');
$router->resource('Contact', 'App\Controller\ContactController');
$router->resource('Invoice', 'App\Controller\InvoiceController');
$router->resource('Product', 'App\Controller\ProductController');
```

### Pattern: API Endpoints
```php
// Routes.php
$router->get('/api/products', 'App\Controller\ProductController', 'apiIndex', 'api.products');
$router->get('/api/products/{id}', 'App\Controller\ProductController', 'apiShow', 'api.product');

// Controller
public function apiIndex()
{
    $products = $this->service->getAll();
    $this->json($products);
}

public function apiShow($id)
{
    $product = $this->service->getById((int)$id);
    $this->json($product ?? ['error' => 'Not found'], $product ? 200 : 404);
}
```

### Pattern: Custom Actions
```php
// Routes.php
$router->post('/products/import', 'App\Controller\ProductController', 'import', 'products.import');
$router->get('/products/search', 'App\Controller\ProductController', 'search', 'products.search');

// Controller
public function import()
{
    // Handle file upload and import
}

public function search()
{
    $query = $_GET['q'] ?? '';
    $results = $this->service->search($query);
    $this->render('product/search', ['results' => $results]);
}
```

### Pattern: Nested Resources
```php
// Routes.php
$router->get('/invoices/{invoice_id}/items', 'App\Controller\InvoiceItemController', 'index');
$router->post('/invoices/{invoice_id}/items', 'App\Controller\InvoiceItemController', 'store');

// Controller
public function index($invoice_id)
{
    $items = $this->service->getByInvoice((int)$invoice_id);
    $this->render('invoiceitem/index', ['items' => $items]);
}
```

## URL Building in Views

For links in views, use the resource URLs:

```php
<!-- List page -->
<a href="/product">All Products</a>

<!-- Create button -->
<a href="/product/create" class="btn">New Product</a>

<!-- Single item -->
<a href="/product/<?= $product['id'] ?>">View</a>

<!-- Edit button -->
<a href="/product/<?= $product['id'] ?>/edit">Edit</a>

<!-- Delete link -->
<a href="/product/<?= $product['id'] ?>/delete">Delete</a>

<!-- Form action -->
<form method="POST" action="/product">
    <!-- Create new -->
</form>

<form method="POST" action="/product/<?= $product['id'] ?>">
    <!-- Update existing -->
</form>
```

## Middleware (Future Enhancement)

The system is designed to easily add middleware support:

```php
// Coming soon:
$router->get('/admin/dashboard', 'App\Controller\AdminController', 'dashboard')
    ->middleware('auth', 'admin');
```

## Cheat Sheet: Controller Methods

```php
class YourController extends BaseController
{
    // Render a view with data
    $this->render('folder/view', ['data' => $value]);
    
    // Redirect
    $this->redirect('/path');
    
    // Flash messages
    $this->flashSuccess('Message');
    $this->flashError('Message');
    $this->flashInfo('Message');
    $this->getFlash('success');
    
    // Error responses
    $this->notFound('Not found');
    $this->forbidden('Forbidden');
    $this->serverError('Error');
    
    // JSON response
    $this->json(['key' => 'value']);
    
    // Validation
    $this->isValidId($id);
    $this->isAjax();
}
```
