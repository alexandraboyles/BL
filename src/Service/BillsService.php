<?php
namespace App\Service;
use App\Repository\BillsRepository;
use InvalidArgumentException;
class BillsService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new BillsRepository();
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
            'suppliers' => $this->repo->getAllSuppliers(),
            'invoices' => $this->repo->getAllInvoices(),
            'manifests' => $this->repo->getAllManifests()
        ];
    }
    public function create(array $data): bool|array
    {
        $this->repo->save($data);
        return true;
    }
    public function update(int $id, array $data): bool|array
    {
        return $this->repo->update($id, $data);
    }
    public function delete(int $id): bool
    {
        if ($id <= 0) throw new InvalidArgumentException("Invalid ID");
        return $this->repo->delete($id);
    }
}
