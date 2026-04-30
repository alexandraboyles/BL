<?php
namespace App\Controller;

use App\Service\AddressDefaultInstructionsService;
use App\Validation\AddressDefaultInstructionsValidator;
use Exception;

class AddressDefaultInstructionsController extends BaseController
{
    private AddressDefaultInstructionsService $service;
    private AddressDefaultInstructionsValidator $validator;

    public function __construct()
    {
        $this->service = new AddressDefaultInstructionsService();
        $this->validator = new AddressDefaultInstructionsValidator();
    }

    public function index()
    {
        try {
            $items = $this->service->getAll();
            $this->render('addressdefaultinstructions/index', ['items' => $items]);
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
        $this->render('addressdefaultinstructions/create', [
            'errors' => $errors,
            'old' => $oldInput,
            'addresses' => $formData['addresses'],
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
                $this->redirect('/addressdefaultinstructions/create');
            }

            $result = $this->service->create($data);
            if (is_array($result)) {
                $_SESSION['create_errors'] = $result;
                $_SESSION['create_old_input'] = $data;
                $this->redirect('/addressdefaultinstructions/create');
            }
            
            $this->flashSuccess("Item created successfully");
            $this->redirect('/addressdefaultinstructions');
        } catch (Exception $e) {
            $_SESSION['create_errors'] = ["Failed to create item: " . $e->getMessage()];
            $_SESSION['create_old_input'] = $_POST;
            $this->redirect('/addressdefaultinstructions/create');
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
            $this->render('addressdefaultinstructions/view', ['item' => $item]); // Fixed
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/addressdefaultinstructions');
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
            $this->render('addressdefaultinstructions/edit', [
                'item' => $item,
                'errors' => $errors,
                'old' => $oldInput,
                'addresses' => $formData['addresses'],
                'customers' => $formData['customers']
            ]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/addressdefaultinstructions');
        }
    }
    
    public function update($id)
    {
        if (!$this->isValidId($id)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/addressdefaultinstructions');
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
                $this->redirect("/addressdefaultinstructions/{$id}/edit");
            }

            $this->flashSuccess("Item updated successfully");
            $this->redirect('/addressdefaultinstructions');
        } catch (Exception $e) {
            $_SESSION["edit_errors_{$id}"] = ["Failed to update item: " . $e->getMessage()];
            $_SESSION["edit_old_input_{$id}"] = $_POST;
            $this->redirect("/addressdefaultinstructions/{$id}/edit");
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
            $this->render('addressdefaultinstructions/delete', ['item' => $item]); // Fixed
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/addressdefaultinstructions');
        }
    }

    public function delete($id = null)
    {
        $deleteId = $id ?? ($_POST['id'] ?? null); // Fixed: consistent with form
        
        if (!$this->isValidId($deleteId)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/addressdefaultinstructions');
        }

        try {
            $this->service->delete((int)$deleteId);
            $this->flashSuccess("Item deleted successfully");
            $this->redirect('/addressdefaultinstructions');
        } catch (Exception $e) {
            $this->flashError($e->getMessage());
            $this->redirect('/addressdefaultinstructions');
        }
    }
}
