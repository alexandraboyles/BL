<?php
namespace App\Service;

use Exception;

class AddressDefaultInstructionsService
{
    public function getAll(): array
    {
        // TODO: Implement using repository
        return [];
    }

    public function getById(int $id): ?array
    {
        if ($id <= 0) {
            throw new Exception("Invalid ID");
        }
        // TODO: Implement using repository
        return null;
    }

    public function create(array $data): bool
    {
        // TODO: Implement using repository
        return true;
    }

    public function update(int $id, array $data): bool
    {
        if ($id <= 0) {
            throw new Exception("Invalid ID");
        }
        // TODO: Implement using repository
        return true;
    }

    public function delete(int $id): bool
    {
        if ($id <= 0) {
            throw new Exception("Invalid ID");
        }
        // TODO: Implement using repository
        return true;
    }
}
