<?php
namespace App\Controller;

use App\Service\UsersService;
use App\Validation\UsersValidator;
use Exception;

class UsersController extends BaseController
{
    private UsersService $service;
    private UsersValidator $validator;

    public function __construct()
    {
        $this->service = new UsersService();
        $this->validator = new UsersValidator();
    }

    private function isValidUuid($id): bool
    {
        return is_string($id) && (bool) preg_match(
            '/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/',
            $id
        );
    }

    public function index()
    {
        try {
            $items = $this->service->getAll();
            $formData = $this->service->getFormData();
            $this->render('users/index', ['items' => $items, 'roles' => $formData['roles']]);
        } catch (Exception $e) {
            $this->flashError("Failed to load items: " . $e->getMessage());
            $this->redirect('/');
        }
    }

    public function create()
    {
        $errors = $this->getFlash('create_errors') ?? [];
        $oldInput = $this->getFlash('create_old_input') ?? [];
        $formData = $this->service->getFormData();
        $this->render('users/create', [
            'errors' => $errors,
            'old' => $oldInput,
            'customers' => $formData['customers'],
            'roles' => $formData['roles'],
            'warehouses' => $formData['warehouses']
        ]);
    }

    public function store()
    {
        try {
            $data = $_POST;
            $errors = $this->validator->validate($data);
            
            if (!empty($errors)) {
                $_SESSION['create_errors'] = $errors;
                $_SESSION['create_old_input'] = $data;
                $this->redirect('/users/create');
            }

            $result = $this->service->create($data);
            if (is_array($result)) {
                $_SESSION['create_errors'] = $result;
                $_SESSION['create_old_input'] = $data;
                $this->redirect('/users/create');
            }
            
            $this->flashSuccess("Item created successfully");
            $this->redirect('/users');
        } catch (Exception $e) {
            $_SESSION['create_errors'] = ["Failed to create item: " . $e->getMessage()];
            $_SESSION['create_old_input'] = $_POST;
            $this->redirect('/users/create');
        }
    }

    public function show($id)
    {
        if (!$this->isValidUuid($id)) {
            $this->notFound("Invalid item ID");
        }

        try {
            $item = $this->service->getById($id);
            if (!$item) {
                $this->notFound("Item not found");
            }
            $formData = $this->service->getFormData();
            $this->render('users/view', ['item' => $item, 'roles' => $formData['roles']]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/users');
        }
    }

    public function edit($id)
    {
        if (!$this->isValidUuid($id)) $this->notFound("Invalid item ID");
        try {
            $item = $this->service->getById($id);
            if (!$item) $this->notFound("Item not found");
            $errors = $this->getFlash("edit_errors_{$id}") ?? [];
            $oldInput = $this->getFlash("edit_old_input_{$id}") ?? [];
            $formData = $this->service->getFormData();
            $this->render('users/edit', [
                'item' => $item,
                'errors' => $errors,
                'old' => $oldInput,
                'customers' => $formData['customers'],
                'roles' => $formData['roles'],
                'warehouses' => $formData['warehouses']
            ]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/users');
        }
    }

    public function update($id)
    {
        if (!$this->isValidUuid($id)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/users');
        }

        if (isset($_POST['_method']) && strtoupper($_POST['_method']) === 'DELETE') {
            return $this->delete($id);
        }

        try {
            $data = $_POST;
            $result = $this->service->update($id, $data);
            
            if (is_array($result)) {
                $_SESSION["edit_errors_{$id}"] = $result;
                $_SESSION["edit_old_input_{$id}"] = $data;
                $this->redirect("/users/{$id}/edit");
            }

            $this->flashSuccess("Item updated successfully");
            $this->redirect('/users');
        } catch (Exception $e) {
            $_SESSION["edit_errors_{$id}"] = ["Failed to update item: " . $e->getMessage()];
            $_SESSION["edit_old_input_{$id}"] = $_POST;
            $this->redirect("/users/{$id}/edit");
        }
    }

    public function confirmDelete($id)
    {
        if (!$this->isValidUuid($id)) {
            $this->notFound("Invalid item ID");
        }

        try {
            $item = $this->service->getById($id);
            if (!$item) {
                $this->notFound("Item not found");
            }
            $this->render('users/delete', ['item' => $item]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/users');
        }
    }

    public function delete($id = null)
    {
        $deleteId = $id ?? ($_POST['id'] ?? null);
        
        if (!$this->isValidUuid($deleteId)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/users');
        }

        try {
            $this->service->delete($deleteId);
            $this->flashSuccess("Item deleted successfully");
            $this->redirect('/users');
        } catch (\Exception $e) {
            $this->flashError($e->getMessage());
            $this->redirect('/users');
        }
    }
}