<?php
namespace App\Controller;

use App\Service\AddressService;
use App\Validation\AddressValidator;
use Exception;

class AddressController extends BaseController
{
    private AddressService $service;
    private AddressValidator $validator;

    public function __construct()
    {
        $this->service = new AddressService();
        $this->validator = new AddressValidator();
    }

    public function index()
    {
        try {
            $items = $this->service->getAll();
            $this->render('address/index', ['items' => $items]);
        } catch (Exception $e) {
            $this->flashError("Failed to load items: " . $e->getMessage());
            $this->redirect('/');
        }
    }

    public function create()
    {
        // Get flash errors
        $errors = $this->getFlash('create_errors') ?? [];
        $oldInput = $this->getFlash('create_old_input') ?? [];
        $this->render('address/create', ['errors' => $errors, 'old' => $oldInput]);
    }

    public function store()
    {
        try {
            $data = $_POST;
            $errors = $this->validator->validate($data);
            
            if (!empty($errors)) {
                $_SESSION['create_errors'] = $errors;
                $_SESSION['create_old_input'] = $data;
                $this->redirect('/addresses/create');
            }

            $result = $this->service->create($data);
            if (is_array($result)) {
                $_SESSION['create_errors'] = $result;
                $_SESSION['create_old_input'] = $data;
                $this->redirect('/addresses/create');
            }
            
            $this->flashSuccess("Item created successfully");
            $this->redirect('/addresses');
        } catch (Exception $e) {
            $_SESSION['create_errors'] = ["Failed to create item: " . $e->getMessage()];
            $_SESSION['create_old_input'] = $_POST;
            $this->redirect('/addresses/create');
        }
    }

    // ... rest of methods remain the same
    public function show($id)
    {
        if (!$this->isValidId($id)) {
            $this->notFound("Invalid item ID");
        }

        try {
            $item = $this->service->getById((int)$id);
            if (!$item) {
                $this->notFound("Item not found");
            }
            $this->render('address/view', ['item' => $item]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/addresses');
        }
    }

    public function edit($id)
    {
        if (!$this->isValidId($id)) {
            $this->notFound("Invalid item ID");
        }

        try {
            $item = $this->service->getById((int)$id);
            if (!$item) {
                $this->notFound("Item not found");
            }

            $errors = $this->getFlash("edit_errors_{$id}") ?? [];
            $oldInput = $this->getFlash("edit_old_input_{$id}") ?? [];
            
            $this->render('address/edit', ['item' => $item, 'errors' => $errors, 'old' => $oldInput]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/addresses');
        }
    }

    public function update($id)
    {
        if (!$this->isValidId($id)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/addresses');
        }

        if (isset($_POST['_method']) && strtoupper($_POST['_method']) === 'DELETE') {
            return $this->delete($id);
        }

        try {
            $data = $_POST;
            $result = $this->service->update((int)$id, $data);
            
            if (is_array($result)) {
                $_SESSION["edit_errors_{$id}"] = $result;
                $_SESSION["edit_old_input_{$id}"] = $data;
                $this->redirect("/addresses/{$id}/edit");
            }

            $this->flashSuccess("Item updated successfully");
            $this->redirect('/addresses');
        } catch (Exception $e) {
            $_SESSION["edit_errors_{$id}"] = ["Failed to update item: " . $e->getMessage()];
            $_SESSION["edit_old_input_{$id}"] = $_POST;
            $this->redirect("/addresses/{$id}/edit");
        }
    }

    public function confirmDelete($id)
    {
        if (!$this->isValidId($id)) {
            $this->notFound("Invalid item ID");
        }

        try {
            $item = $this->service->getById((int)$id);
            if (!$item) {
                $this->notFound("Item not found");
            }
            $this->render('address/delete', ['item' => $item]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/addresses');
        }
    }

    public function delete($id = null)
    {
        $deleteId = $id ?? ($_POST['address_id'] ?? null);
        
        if (!$this->isValidId($deleteId)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/addresses');
        }

        try {
            $this->service->delete((int)$deleteId);
            $this->flashSuccess("Item deleted successfully");
            $this->redirect('/addresses');
        } catch (Exception $e) {
            $this->flashError("Failed to delete item: " . $e->getMessage());
            $this->redirect('/addresses');
        }
    }
}