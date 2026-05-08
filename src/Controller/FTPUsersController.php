<?php
namespace App\Controller;

use App\Service\FTPUsersService;
use App\Validation\FTPUsersValidator;
use Exception;

class FTPUsersController extends BaseController
{
    private FTPUsersService $service;
    private FTPUsersValidator $validator;

    public function __construct()
    {
        $this->service = new FTPUsersService();
        $this->validator = new FTPUsersValidator();
    }

    public function index()
    {
        try {
            $items = $this->service->getAll();
            $this->render('ftpusers/index', ['items' => $items]);
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
        $this->render('ftpusers/create', ['errors' => $errors, 'old' => $oldInput]);
    }

    public function store()
    {
        try {
            $data = $_POST;
            $errors = $this->validator->validate($data);
            
            if (!empty($errors)) {
                $_SESSION['create_errors'] = $errors;
                $_SESSION['create_old_input'] = $data;
                $this->redirect('/ftpusers/create');
            }

            $result = $this->service->create($data);
            if (is_array($result)) {
                $_SESSION['create_errors'] = $result;
                $_SESSION['create_old_input'] = $data;
                $this->redirect('/ftpusers/create');
            }
            
            $this->flashSuccess("Item created successfully");
            $this->redirect('/ftpusers');
        } catch (Exception $e) {
            $_SESSION['create_errors'] = ["Failed to create item: " . $e->getMessage()];
            $_SESSION['create_old_input'] = $_POST;
            $this->redirect('/ftpusers/create');
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
            $this->render('ftpusers/view', ['item' => $item]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/ftpusers');
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
            
            $this->render('ftpusers/edit', ['item' => $item, 'errors' => $errors, 'old' => $oldInput]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/ftpusers');
        }
    }

    public function update($id)
    {
        if (!$this->isValidId($id)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/ftpusers');
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
                $this->redirect("/ftpusers/{$id}/edit");
            }

            $this->flashSuccess("Item updated successfully");
            $this->redirect('/ftpusers');
        } catch (Exception $e) {
            $_SESSION["edit_errors_{$id}"] = ["Failed to update item: " . $e->getMessage()];
            $_SESSION["edit_old_input_{$id}"] = $_POST;
            $this->redirect("/ftpusers/{$id}/edit");
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
            $this->render('ftpusers/delete', ['item' => $item]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/ftpusers');
        }
    }

    public function delete($id = null)
    {
        $deleteId = $id ?? ($_POST['FTPUsers_id'] ?? null);
        
        if (!$this->isValidId($deleteId)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/ftpusers');
        }

        try {
            $this->service->delete((int)$deleteId);
            $this->flashSuccess("Item deleted successfully");
            $this->redirect('/ftpusers');
        } catch (\Exception $e) {
            $this->flashError($e->getMessage());
            $this->redirect('/ftpusers');
        }
    }
}