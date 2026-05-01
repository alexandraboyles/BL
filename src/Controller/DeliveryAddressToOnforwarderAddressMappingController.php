<?php
namespace App\Controller;

use App\Service\DeliveryAddressToOnforwarderAddressMappingService;
use Exception;

class DeliveryAddressToOnforwarderAddressMappingController extends BaseController
{
    private DeliveryAddressToOnforwarderAddressMappingService $service;

    public function __construct()
    {
        $this->service = new DeliveryAddressToOnforwarderAddressMappingService();
    }

    public function index()
    {
        try {
            $items = $this->service->getAll();
            $this->render('deliveryaddresstoonforwarderaddressmapping/index', ['items' => $items]);
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
        $this->render('deliveryaddresstoonforwarderaddressmapping/create', [
            'errors' => $errors,
            'old' => $oldInput,
            'addresses' => $formData['addresses'],
            'customers' => $formData['customers'],
            'products' => $formData['products']
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
                $this->redirect('/deliveryaddresstoonforwarderaddressmapping/create');
            }
            
            $this->flashSuccess("Item created successfully");
            $this->redirect('/deliveryaddresstoonforwarderaddressmapping');
        } catch (Exception $e) {
            $_SESSION['create_errors'] = ["Failed to create item: " . $e->getMessage()];
            $_SESSION['create_old_input'] = $_POST;
            $this->redirect('/deliveryaddresstoonforwarderaddressmapping/create');
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
            $this->render('deliveryaddresstoonforwarderaddressmapping/view', ['item' => $item]); // Fixed
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/deliveryaddresstoonforwarderaddressmapping');
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
            $this->render('deliveryaddresstoonforwarderaddressmapping/edit', [
                'item' => $item,
                'errors' => $errors,
                'old' => $oldInput,
                'addresses' => $formData['addresses'],
                'customers' => $formData['customers'],
                'products' => $formData['products']
            ]);
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/deliveryaddresstoonforwarderaddressmapping');
        }
    }
    
    public function update($id)
    {
        if (!$this->isValidId($id)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/deliveryaddresstoonforwarderaddressmapping');
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
                $this->redirect("/deliveryaddresstoonforwarderaddressmapping/{$id}/edit");
            }

            $this->flashSuccess("Item updated successfully");
            $this->redirect('/deliveryaddresstoonforwarderaddressmapping');
        } catch (Exception $e) {
            $_SESSION["edit_errors_{$id}"] = ["Failed to update item: " . $e->getMessage()];
            $_SESSION["edit_old_input_{$id}"] = $_POST;
            $this->redirect("/deliveryaddresstoonforwarderaddressmapping/{$id}/edit");
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
            $this->render('deliveryaddresstoonforwarderaddressmapping/delete', ['item' => $item]); // Fixed
        } catch (Exception $e) {
            $this->flashError("Failed to load item: " . $e->getMessage());
            $this->redirect('/deliveryaddresstoonforwarderaddressmapping');
        }
    }

    public function delete($id = null)
    {
        $deleteId = $id ?? ($_POST['id'] ?? null); // Fixed: consistent with form
        
        if (!$this->isValidId($deleteId)) {
            $this->flashError("Invalid item ID");
            $this->redirect('/deliveryaddresstoonforwarderaddressmapping');
        }

        try {
            $this->service->delete((int)$deleteId);
            $this->flashSuccess("Item deleted successfully");
            $this->redirect('/deliveryaddresstoonforwarderaddressmapping');
        } catch (Exception $e) {
            $this->flashError($e->getMessage());
            $this->redirect('/deliveryaddresstoonforwarderaddressmapping');
        }
    }
}
