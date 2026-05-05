<?php
namespace App\Controller;

use App\Service\ContactsService;
use App\Validation\ContactsValidator;
use Exception;

class ContactsController extends BaseController
{
    private ContactsService $service;
    private ContactsValidator $validator;

    public function __construct()
    {
        $this->service = new ContactsService();
        $this->validator = new ContactsValidator();
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
            $this->render('contacts/index', ['items' => $items]);
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
        $this->render('contacts/create', [
            'errors' => $errors,
            'old' => $oldInput,
            'customers' => $formData['customers']
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
                $this->redirect('/contacts/create');
            }

            $result = $this->service->create($data);
            if (is_array($result)) {
                $_SESSION['create_errors'] = $result;
                $_SESSION['create_old_input'] = $data;
                $this->redirect('/contacts/create');
            }
            
            $this->flashSuccess("Item created successfully");
            $this->redirect('/contacts');
        } catch (Exception $e) {
            $_SESSION['create_errors'] = ["Failed to create item: " . $e->getMessage()];
            $_SESSION['create_old_input'] = $_POST;
            $this->redirect('/contacts/create');
        }
    }

    // ... rest of methods remain the same
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
            $this->render('contacts/view', ['item' => $item]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/contacts');
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
            $this->render('contacts/edit', [
                'item' => $item,
                'errors' => $errors,
                'old' => $oldInput,
                'customers' => $formData['customers']
            ]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/contacts');
        }
    }

    public function update($id)
    {
        if (!$this->isValidUuid($id)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/contacts');
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
                $this->redirect("/contacts/{$id}/edit");
            }

            $this->flashSuccess("Item updated successfully");
            $this->redirect('/contacts');
        } catch (Exception $e) {
            $_SESSION["edit_errors_{$id}"] = ["Failed to update item: " . $e->getMessage()];
            $_SESSION["edit_old_input_{$id}"] = $_POST;
            $this->redirect("/contacts/{$id}/edit");
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
            $this->render('contacts/delete', ['item' => $item]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/contacts');
        }
    }

    public function delete($id = null)
    {
        $deleteId = $id ?? ($_POST['id'] ?? null);
        
        if (!$this->isValidUuid($deleteId)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/contacts');
        }

        try {
            $this->service->delete($deleteId);
            $this->flashSuccess("Item deleted successfully");
            $this->redirect('/contacts');
        } catch (\Exception $e) {
            $this->flashError($e->getMessage());
            $this->redirect('/contacts');
        }
    }
}