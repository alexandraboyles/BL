<?php
namespace App\Controller;

use App\Service\SurchargesService;
use App\Validation\SurchargesValidator;
use Exception;

class SurchargesController extends BaseController
{
    private SurchargesService $service;
    private SurchargesValidator $validator;

    public function __construct()
    {
        $this->service = new SurchargesService();
        $this->validator = new SurchargesValidator();
    }

    public function index()
    {
        try {
            $items = $this->service->getAll();
            $this->render('surcharges/index', ['items' => $items]);
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
        $this->render('surcharges/create', [
            'errors' => $errors,
            'old' => $oldInput,
            'feecategories' => $formData['feecategories']
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
                $this->redirect('/surcharges/create');
            }

            $result = $this->service->create($data);
            if (is_array($result)) {
                $_SESSION['create_errors'] = $result;
                $_SESSION['create_old_input'] = $data;
                $this->redirect('/surcharges/create');
            }
            
            $this->flashSuccess("Item created successfully");
            $this->redirect('/surcharges');
        } catch (Exception $e) {
            $_SESSION['create_errors'] = ["Failed to create item: " . $e->getMessage()];
            $_SESSION['create_old_input'] = $_POST;
            $this->redirect('/surcharges/create');
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
            $this->render('surcharges/view', ['item' => $item]); // Fixed
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/surcharges');
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
            $this->render('surcharges/edit', [
                'item' => $item,
                'errors' => $errors,
                'old' => $oldInput,
                'feecategories' => $formData['feecategories']
            ]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/surcharges');
        }
    }
    
    public function update($id)
    {
        if (!$this->isValidId($id)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/surcharges');
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
                $this->redirect("/surcharges/{$id}/edit");
            }

            $result = $this->service->update((int)$id, $data);
            
            if (is_array($result)) {
                $_SESSION["edit_errors_{$id}"] = $result;
                $_SESSION["edit_old_input_{$id}"] = $data;
                $this->redirect("/surcharges/{$id}/edit");
            }

            $this->flashSuccess("Item updated successfully");
            $this->redirect('/surcharges');
        } catch (Exception $e) {
            $_SESSION["edit_errors_{$id}"] = ["Failed to update item: " . $e->getMessage()];
            $_SESSION["edit_old_input_{$id}"] = $_POST;
            $this->redirect("/surcharges/{$id}/edit");
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
            $this->render('surcharges/delete', ['item' => $item]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/surcharges');
        }
    }

    public function delete($id = null)
    {
        $deleteId = $id ?? ($_POST['id'] ?? null); // Fixed: consistent with form
        
        if (!$this->isValidId($deleteId)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/surcharges');
        }

        try {
            $this->service->delete((int)$deleteId);
            $this->flashSuccess("Item deleted successfully");
            $this->redirect('/surcharges');
        } catch (Exception $e) {
            $this->flashError($e->getMessage());
            $this->redirect('/surcharges');
        }
    }
}
