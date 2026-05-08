<?php
namespace App\Service;
use App\Repository\DocumentsRepository;
use InvalidArgumentException;
class DocumentsService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new DocumentsRepository();
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
            'saleOrders' => $this->repo->getAllSaleOrders(),
            'customers' => $this->repo->getAllCustomers(),
            'consignments' => $this->repo->getAllConsignments()
        ];
    }
    public function create(array $data): bool|array
    {
        if ($this->repo->existsById((int)$data['id'])) {
            return ["Document ID is already in use."];
        }

        $this->repo->save($data);
        return true;
    }
    public function update(int $id, array $data): bool|array
    {
        if ((int)$id !== (int)$data['id'] && $this->repo->existsById((int)$data['id'])) {
            return ["Document ID is already in use."];
        }

        return $this->repo->update($id, $data);
    }
    public function delete(int $id): bool
    {
        if ($id <= 0) throw new InvalidArgumentException("Invalid ID");
        return $this->repo->delete($id);
    }
}
