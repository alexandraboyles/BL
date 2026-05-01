<?php
namespace App\Controller;

use App\Service\AddressToInvoiceCustomerMappingService;
use Exception;

class AddressToInvoiceCustomerMappingController extends BaseController
{
    private AddressToInvoiceCustomerMappingService $service;

    public function __construct()
    {
        $this->service = new AddressToInvoiceCustomerMappingService();
    }

    public function index()
    {
        try {
            $items = $this->service->getAll();
            $this->render('addresstoinvoicecustomermapping/index', ['items' => $items]);
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
        $this->render('addresstoinvoicecustomermapping/create', [
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

            $result = $this->service->create($data);
            if (is_array($result)) {
                $_SESSION['create_errors'] = $result;
                $_SESSION['create_old_input'] = $data;
                $this->redirect('/addresstoinvoicecustomermapping/create');
            }
            
            $this->flashSuccess("Item created successfully");
            $this->redirect('/addresstoinvoicecustomermapping');
        } catch (Exception $e) {
            $_SESSION['create_errors'] = ["Failed to create item: " . $e->getMessage()];
            $_SESSION['create_old_input'] = $_POST;
            $this->redirect('/addresstoinvoicecustomermapping/create');
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
            $this->render('addresstoinvoicecustomermapping/view', ['item' => $item]); // Fixed
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/addresstoinvoicecustomermapping');
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
            $this->render('addresstoinvoicecustomermapping/edit', [
                'item' => $item,
                'errors' => $errors,
                'old' => $oldInput,
                'addresses' => $formData['addresses'],
                'customers' => $formData['customers']
            ]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/addresstoinvoicecustomermapping');
        }
    }
    
    public function update($id)
    {
        if (!$this->isValidId($id)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/addresstoinvoicecustomermapping');
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
                $this->redirect("/addresstoinvoicecustomermapping/{$id}/edit");
            }

            $this->flashSuccess("Item updated successfully");
            $this->redirect('/addresstoinvoicecustomermapping');
        } catch (Exception $e) {
            $_SESSION["edit_errors_{$id}"] = ["Failed to update item: " . $e->getMessage()];
            $_SESSION["edit_old_input_{$id}"] = $_POST;
            $this->redirect("/addresstoinvoicecustomermapping/{$id}/edit");
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
            $this->render('addresstoinvoicecustomermapping/delete', ['item' => $item]); // Fixed
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/addresstoinvoicecustomermapping');
        }
    }

    public function delete($id = null)
    {
        $deleteId = $id ?? ($_POST['id'] ?? null); // Fixed: consistent with form
        
        if (!$this->isValidId($deleteId)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/addresstoinvoicecustomermapping');
        }

        try {
            $this->service->delete((int)$deleteId);
            $this->flashSuccess("Item deleted successfully");
            $this->redirect('/addresstoinvoicecustomermapping');
        } catch (Exception $e) {
            $this->flashError($e->getMessage());
            $this->redirect('/addresstoinvoicecustomermapping');
        }
    }
}
