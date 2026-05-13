<?php
namespace App\Service;

use App\Repository\UsersRepository;
use InvalidArgumentException;

class UsersService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new UsersRepository();
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

    // Provide dropdown lists
    public function getFormData(): array
    {
        return [
            'customers' => $this->repo->getAllCustomers(),
            'roles' => $this->repo->getAllRoles(),
            'warehouses' => $this->repo->getAllWarehouses()
        ];
    }

    public function create(array $data): bool|array
    {
        if ($this->repo->existsByFullName(trim($data['fullName']))) {
            return ["User full name is already in use."];
        }

        if ($this->repo->existsByEmail($data['email'])) {
            return ["Email is already in use."];
        }

        $this->repo->save($data);
        return true;
    }

    public function update(string $originalUserId, array $data): bool|array
    {
        if ($this->repo->existsByFullName($data['fullName'], (string)$originalUserId)) {
            return ["Full Name is already in use."];
        }

        if ($this->repo->existsByEmail(trim($data['email']), (string)$originalUserId)) {
            return ["Email is already in use."];
        }

        return $this->repo->update($originalUserId, $data);
    }

    public function delete(string $id): bool
    {
        if (trim($id) === '') {
            throw new InvalidArgumentException("Invalid ID");
        }
        return $this->repo->delete($id);
    }
}
