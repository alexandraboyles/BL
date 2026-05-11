<?php
namespace App\Service;
use App\Repository\InvoicesRepository;
use App\Validation\InvoicesValidator;
use InvalidArgumentException;
class InvoicesService
{
    private $repo;
    private $validator;

    public function __construct()
    {
        $this->repo = new InvoicesRepository();
        $this->validator = new InvoicesValidator();
    }
    public function getAll(): array
    {
        return $this->repo->findAll();
    }
    public function getById(int $id): ?array
    {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid ID");
        }
        return $this->repo->find($id);
    }
    // Provide dropdown lists
    public function getFormData(): array
    {
        return [
            'customers' => $this->repo->getAllCustomers(),
            'rateCards' => $this->repo->getAllRateCards(),
            'manifests' => $this->repo->getAllManifests()
        ];
    }
    public function create(array $data): bool|array
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        if ($this->repo->existsById((int)$data['invoice_id'])) {
            return ["Invoice ID is already in use."];
        }

        $this->repo->save($data);
        return true;
    }

    public function update(int $originalId, array $data): bool|array
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        // Check if invoice_id (the integer) is changed and if the new one already exists
        $existing = $this->repo->find($originalId);
        if (!$existing) {
            return ["Invoice not found."];
        }

        if ((int)$existing['invoice_id'] !== (int)$data['invoice_id'] && $this->repo->existsById((int)$data['invoice_id'])) {
            return ["Invoice ID is already in use."];
        }

        return $this->repo->update($originalId, $data);
    }
    public function delete(int $id): bool
    {
        if ($id <= 0) throw new InvalidArgumentException("Invalid ID");
        return $this->repo->delete($id);
    }
}
