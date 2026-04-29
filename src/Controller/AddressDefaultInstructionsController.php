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

    /**
     * Display a listing of the resource
     * GET /addressdefaultinstructions
     */
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

    /**
     * Show the form for creating a new resource
     * GET /addressdefaultinstructions/create
     */
    public function create()
    {
        $errors = $this->getFlash('create_errors') ?? [];
        $this->render('addressdefaultinstructions/create', ['errors' => $errors]);
    }

    /**
     * Store a newly created resource in storage
     * POST /addressdefaultinstructions
     */
    public function store($data)
    {
        try {
            // Validate input
            $errors = $this->validator->validate($data);
            if (!empty($errors)) {
                $_SESSION['create_errors'] = $errors;
                $this->redirect('/addressdefaultinstructions/create');
            }

            // Create the resource
            $this->service->create($data);
            
            $this->flashSuccess("Instruction created successfully");
            $this->redirect('/addressdefaultinstructions');
        } catch (Exception $e) {
            $this->flashError("Failed to create instruction: " . $e->getMessage());
            $this->redirect('/addressdefaultinstructions/create');
        }
    }

    /**
     * Display the specified resource
     * GET /addressdefaultinstructions/{id}
     */
    public function show($id)
    {
        if (!$this->isValidId($id)) {
            $this->notFound("Invalid instruction ID");
        }

        try {
            $item = $this->service->getById((int)$id);
            if (!$item) {
                $this->notFound("Instruction not found");
            }

            $this->render('addressdefaultinstructions/view', ['item' => $item]);
        } catch (Exception $e) {
            $this->flashError("Failed to load instruction: " . $e->getMessage());
            $this->redirect('/addressdefaultinstructions');
        }
    }

    /**
     * Show the form for editing the specified resource
     * GET /addressdefaultinstructions/{id}/edit
     */
    public function edit($id)
    {
        if (!$this->isValidId($id)) {
            $this->notFound("Invalid instruction ID");
        }

        try {
            $item = $this->service->getById((int)$id);
            if (!$item) {
                $this->notFound("Instruction not found");
            }

            $errors = $_SESSION['edit_errors'][$id] ?? [];
            unset($_SESSION['edit_errors'][$id]);

            $this->render('addressdefaultinstructions/edit', ['item' => $item, 'errors' => $errors]);
        } catch (Exception $e) {
            $this->flashError("Failed to load instruction: " . $e->getMessage());
            $this->redirect('/addressdefaultinstructions');
        }
    }

    /**
     * Update the specified resource in storage
     * POST /addressdefaultinstructions/{id}
     */
    public function update($id)
    {
        if (!$this->isValidId($id)) {
            $this->flashError("Invalid instruction ID");
            $this->redirect('/addressdefaultinstructions');
        }

        try {
            // Get POST data (or from $_POST if not passed as parameter)
            $data = $_POST;

            // Validate input
            $errors = $this->validator->validate($data);
            if (!empty($errors)) {
                $_SESSION['edit_errors'][$id] = $errors;
                $this->redirect("/addressdefaultinstructions/{$id}/edit");
            }

            // Update the resource
            $this->service->update((int)$id, $data);

            $this->flashSuccess("Instruction updated successfully");
            $this->redirect('/addressdefaultinstructions');
        } catch (Exception $e) {
            $this->flashError("Failed to update instruction: " . $e->getMessage());
            $this->redirect("/addressdefaultinstructions/{$id}/edit");
        }
    }

    /**
     * Show delete confirmation for the specified resource
     * GET /addressdefaultinstructions/{id}/delete
     */
    public function confirmDelete($id)
    {
        if (!$this->isValidId($id)) {
            $this->notFound("Invalid instruction ID");
        }

        try {
            $item = $this->service->getById((int)$id);
            if (!$item) {
                $this->notFound("Instruction not found");
            }

            $this->render('addressdefaultinstructions/delete', ['item' => $item]);
        } catch (Exception $e) {
            $this->flashError("Failed to load instruction: " . $e->getMessage());
            $this->redirect('/addressdefaultinstructions');
        }
    }

    /**
     * Delete the specified resource
     * DELETE /addressdefaultinstructions/{id} or form POST from confirmDelete
     */
    public function delete($id)
    {
        if (!$this->isValidId($id)) {
            $this->flashError("Invalid instruction ID");
            $this->redirect('/addressdefaultinstructions');
        }

        try {
            $this->service->delete((int)$id);
            $this->flashSuccess("Instruction deleted successfully");
            $this->redirect('/addressdefaultinstructions');
        } catch (Exception $e) {
            $this->flashError("Failed to delete instruction: " . $e->getMessage());
            $this->redirect('/addressdefaultinstructions');
        }
    }
}
