<?php
namespace App\Service;

use App\Repository\DriversRepository;
use App\Validation\DriversValidator;
use InvalidArgumentException;

class DriversService
{
    private $repo;
    private $validator;

    public function __construct()
    {
        $this->repo = new DriversRepository();
        $this->validator = new DriversValidator();
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

        if ($this->repo->existsByDriverName(trim($data['driver_name']))) {
            return ["Driver name is already in use."];
        }

        $this->repo->save($data);
        return true;
    }

    public function update(string $originalDriverId, array $data): bool|array
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        return $this->repo->update($originalDriverId, $data);
    }

    public function delete(string $id): bool
    {
        if (trim($id) === '') {
            throw new InvalidArgumentException("Invalid ID");
        }
        return $this->repo->delete($id);
    }
}
