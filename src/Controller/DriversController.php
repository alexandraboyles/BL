<?php
namespace App\Controller;

use App\Service\DriversService;
use App\Validation\DriversValidator;
use Exception;

class DriversController extends BaseController
{
    private DriversService $service;
    private DriversValidator $validator;

    public function __construct()
    {
        $this->service = new DriversService();
        $this->validator = new DriversValidator();
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
            $this->render('drivers/index', ['items' => $items]);
        } catch (Exception $e) {
            $this->flashError("Failed to load items: " . $e->getMessage());
            $this->redirect('/');
        }
    }

    public function create()
    {
        $errors = $this->getFlash('create_errors') ?? [];
        $oldInput = $this->getFlash('create_old_input') ?? [];
        $this->render('drivers/create', [
            'errors' => $errors,
            'old' => $oldInput
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
                $this->redirect('/drivers/create');
            }

            $result = $this->service->create($data);
            if (is_array($result)) {
                $_SESSION['create_errors'] = $result;
                $_SESSION['create_old_input'] = $data;
                $this->redirect('/drivers/create');
            }
            
            $this->flashSuccess("Item created successfully");
            $this->redirect('/drivers');
        } catch (Exception $e) {
            $_SESSION['create_errors'] = ["Failed to create item: " . $e->getMessage()];
            $_SESSION['create_old_input'] = $_POST;
            $this->redirect('/drivers/create');
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
            $this->render('drivers/view', ['item' => $item]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/drivers');
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
            $this->render('drivers/edit', [
                'item' => $item,
                'errors' => $errors,
                'old' => $oldInput
            ]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/drivers');
        }
    }

    public function update($id)
    {
        if (!$this->isValidUuid($id)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/drivers');
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
                $this->redirect("/drivers/{$id}/edit");
            }

            $this->flashSuccess("Item updated successfully");
            $this->redirect('/drivers');
        } catch (Exception $e) {
            $_SESSION["edit_errors_{$id}"] = ["Failed to update item: " . $e->getMessage()];
            $_SESSION["edit_old_input_{$id}"] = $_POST;
            $this->redirect("/drivers/{$id}/edit");
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
            $this->render('drivers/delete', ['item' => $item]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/drivers');
        }
    }

    public function delete($id = null)
    {
        $deleteId = $id ?? ($_POST['id'] ?? null);
        
        if (!$this->isValidUuid($deleteId)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/drivers');
        }

        try {
            $this->service->delete($deleteId);
            $this->flashSuccess("Item deleted successfully");
            $this->redirect('/drivers');
        } catch (\Exception $e) {
            $this->flashError($e->getMessage());
            $this->redirect('/drivers');
        }
    }
}