<?php
namespace App\Service;

use App\Repository\CustomersRepository;
use InvalidArgumentException;

class CustomersService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new CustomersRepository();
    }

    public function getAll(): array
    {
        return $this->repo->findAll();
    }

    public function getById(string $id): ?array
    {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid ID");
        }
        return $this->repo->find($id);
    }

    public function create(array $data): bool|array
    {
        if ($this->repo->existsByCustomerName(trim($data['customer_name']))) {
            return ["Customer name is already in use."];
        }

        $this->repo->save($data);
        return true;
    }

    public function update(string $originalCustomerId, array $data): bool|array
    {
        if ($this->repo->existsByCustomerName($data['customer_name'], (string)$originalCustomerId)) {
            return ["Customer Name is already in use."];
        }

        return $this->repo->update($originalCustomerId, $data);
    }

    public function delete(string $id): bool
    {
        if (trim($id) === '') {
            throw new InvalidArgumentException("Invalid ID");
        }
        return $this->repo->delete($id);
    }
}
