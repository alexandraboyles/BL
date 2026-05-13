<?php
namespace App\Service;

use App\Repository\DriversRepository;
use InvalidArgumentException;

class DriversService
{
    private $repo;
    private $validator;

    public function __construct()
    {
        $this->repo = new DriversRepository();
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
        if ($this->repo->existsByDriverName(trim($data['driver_name']))) {
            return ["Driver name is already in use."];
        }
        if ($this->repo->existsByEmail(trim($data['email']))) {
            return ["Email is already in use."];
        }

        $this->repo->save($data);
        return true;
    }

    public function update(string $originalDriverId, array $data): bool|array
    {
        if ($this->repo->existsByDriverName($data['driver_name'], (string)$originalDriverId)) {
            return ["Driver Name is already in use."];
        }

        if ($this->repo->existsByEmail(trim($data['email']), (string)$originalDriverId)) {
            return ["Email is already in use."];
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
