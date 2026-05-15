<?php
namespace App\Service;
use App\Repository\ProductsRepository;
use App\Validation\ProductsValidator;
use InvalidArgumentException;
class ProductsService
{
    private $repo;
    private $validator;

    public function __construct()
    {
        $this->repo = new ProductsRepository();
        $this->validator = new ProductsValidator();
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
            'customers' => $this->repo->getAllCustomers()
        ];
    }
    public function create(array $data): bool|array
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        if ($this->repo->existsById((int)$data['product_id'])) {
            return ["Product ID is already in use."];
        }

        if ($this->repo->existsByTitle($data['title'])) {  
            return ["Title is already in use."];
        }

        if ($this->repo->existsBySKU($data['sku'])) {  
            return ["SKU is already in use."];
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

        if ((int)$originalId !== (int)$data['product_id'] && $this->repo->existsById((int)$data['product_id'])) {
            return ["Product ID is already in use."];
        }

        if ($this->repo->existsByTitle($data['title'], (string)$originalId)) {
            return ["Title is already in use."];
        }

        if ($this->repo->existsBySKU($data['sku'], (string)$originalId)) {
            return ["SKU is already in use."];
        }

        return $this->repo->update($originalId, $data);
    }
    public function delete(int $id): bool
    {
        if ($id <= 0) throw new InvalidArgumentException("Invalid ID");
        return $this->repo->delete($id);
    }
}
