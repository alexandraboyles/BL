<?php
namespace App\Service;

use App\Repository\UsersRepository;
use App\Validation\UsersValidator;
use InvalidArgumentException;

class UsersService
{
    private $repo;
    private $validator;

    public function __construct()
    {
        $this->repo = new UsersRepository();
        $this->validator = new UsersValidator();
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
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        if ($this->repo->existsByFullName(trim($data['fullName']))) {
            return ["User full name is already in use."];
        }

        $this->repo->save($data);
        return true;
    }

    public function update(string $originalUserId, array $data): bool|array
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
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
