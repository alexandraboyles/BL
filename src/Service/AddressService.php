<?php
namespace App\Service;

use App\Repository\AddressRepository;
use App\Validation\AddressValidator;
use InvalidArgumentException;

class AddressService
{
    private $repo;
    private $validator;

    public function __construct()
    {
        $this->repo = new AddressRepository();
        $this->validator = new AddressValidator();
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

    public function create(array $data): bool|array
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        if ($this->repo->existsByAddressId((int)$data['address_id'])) {
            return ["Address ID is already in use."];
        }

        if ($this->repo->existsByAddressName(trim($data['address_name']))) {
            return ["Address name is already in use."];
        }

        $this->repo->save($data);
        return true;
    }

    public function update(int $originalAddressId, array $data): bool|array
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        if ((int)$originalAddressId !== (int)$data['address_id'] && $this->repo->existsByAddressId((int)$data['address_id'])) {
            return ["Address ID is already in use."];
        }

        if ($this->repo->existsByAddressName(trim($data['address_name']), (int)$originalAddressId)) {
            return ["Address name is already in use."];
        }

        return $this->repo->update($originalAddressId, $data);
    }

    public function delete(int $id): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid ID");
        }
        return $this->repo->delete($id);
    }
}
