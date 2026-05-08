<?php
namespace App\Service;

use App\Repository\CustomersRepository;
use App\Validation\CustomersValidator;
use InvalidArgumentException;

class CustomersService
{
    private $repo;
    private $validator;

    public function __construct()
    {
        $this->repo = new CustomersRepository();
        $this->validator = new CustomersValidator();
    }

    public function getAll(): array
    {
        return $this->repo->findAll();
    }

    public function getById(string $id): ?array
    {
        if (trim($id) === '') {
            throw new InvalidArgumentException("Invalid ID");
        }
        return $this->repo->find($id);
    }

    public function create(array $data): bool|array
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        if ($this->repo->existsByCustomerName(trim($data['customer_name']))) {
            return ["Customer name is already in use."];
        }

        $this->repo->save($data);
        return true;
    }

    public function update(string $originalCustomerId, array $data): bool|array
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
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
