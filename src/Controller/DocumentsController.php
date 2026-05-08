<?php
namespace App\Controller;

use App\Service\DocumentsService;
use App\Validation\DocumentsValidator;
use Exception;

class DocumentsController extends BaseController
{
    private DocumentsService $service;
    private DocumentsValidator $validator;

    public function __construct()
    {
        $this->service = new DocumentsService();
        $this->validator = new DocumentsValidator();
    }

    public function index()
    {
        try {
            $items = $this->service->getAll();
            $this->render('documents/index', ['items' => $items]);
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
        $this->render('documents/create', [
            'errors' => $errors,
            'old' => $oldInput,
            'saleOrders' => $formData['saleOrders'],
            'customers' => $formData['customers'],
            'consignments' => $formData['consignments']
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
                $this->redirect('/documents/create');
            }

            $result = $this->service->create($data);
            if (is_array($result)) {
                $_SESSION['create_errors'] = $result;
                $_SESSION['create_old_input'] = $data;
                $this->redirect('/documents/create');
            }
            
            $this->flashSuccess("Item created successfully");
            $this->redirect('/documents');
        } catch (Exception $e) {
            $_SESSION['create_errors'] = ["Failed to create item: " . $e->getMessage()];
            $_SESSION['create_old_input'] = $_POST;
            $this->redirect('/documents/create');
        }
    }

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
            $this->render('documents/view', ['item' => $item]); // Fixed
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/documents');
        }
    }

    public function edit($id)
    {
        if (!$this->isValidId($id)) $this->notFound("Invalid item ID");
        try {
            $item = $this->service->getById((int)$id);
            if (!$item) $this->notFound("Item not found");
            $errors = $this->getFlash("edit_errors_{$id}") ?? [];
            $oldInput = $this->getFlash("edit_old_input_{$id}") ?? [];
            $formData = $this->service->getFormData();
            $this->render('documents/edit', [
                'item' => $item,
                'errors' => $errors,
                'old' => $oldInput,
                'saleOrders' => $formData['saleOrders'],
                'customers' => $formData['customers'],
                'consignments' => $formData['consignments']
            ]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/documents');
        }
    }
    
    public function update($id)
    {
        if (!$this->isValidId($id)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/documents');
        }

        if (isset($_POST['_method']) && strtoupper($_POST['_method']) === 'DELETE') {
            return $this->delete($id);
        }

        try {
            $data = $_POST;
            $errors = $this->validator->validate($data);
            
            if (!empty($errors)) {
                $_SESSION["edit_errors_{$id}"] = $errors;
                $_SESSION["edit_old_input_{$id}"] = $data;
                $this->redirect("/documents/{$id}/edit");
            }

            $result = $this->service->update((int)$id, $data);
            
            if (is_array($result)) {
                $_SESSION["edit_errors_{$id}"] = $result;
                $_SESSION["edit_old_input_{$id}"] = $data;
                $this->redirect("/documents/{$id}/edit");
            }

            $this->flashSuccess("Item updated successfully");
            $this->redirect('/documents');
        } catch (Exception $e) {
            $_SESSION["edit_errors_{$id}"] = ["Failed to update item: " . $e->getMessage()];
            $_SESSION["edit_old_input_{$id}"] = $_POST;
            $this->redirect("/documents/{$id}/edit");
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
            $this->render('documents/delete', ['item' => $item]); // Fixed
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/documents');
        }
    }

    public function delete($id = null)
    {
        $deleteId = $id ?? ($_POST['id'] ?? null); // Fixed: consistent with form
        
        if (!$this->isValidId($deleteId)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/documents');
        }

        try {
            $this->service->delete((int)$deleteId);
            $this->flashSuccess("Item deleted successfully");
            $this->redirect('/documents');
        } catch (Exception $e) {
            $this->flashError($e->getMessage());
            $this->redirect('/documents');
        }
    }
}
