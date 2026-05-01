<?php
namespace App\Service;
use App\Repository\AddressStringsRepository;
use App\Validation\AddressStringsValidator;
use InvalidArgumentException;
class AddressStringsService
{
    private $repo;
    private $validator;
    public function __construct()
    {
        $this->repo = new AddressStringsRepository();
        $this->validator = new AddressStringsValidator();
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
            'addresses' => $this->repo->getAllAddresses(),
            'customers' => $this->repo->getAllCustomers(),
        ];
    }
    public function create(array $data): bool|array
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        if ($this->repo->existsById((int)$data['id'])) {
            return ["Address String ID is already in use."];
        }

        $this->repo->save($data);
        return true;
    }
    public function update(int $id, array $data): bool|array
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        if ((int)$id !== (int)$data['id'] && $this->repo->existsById((int)$data['id'])) {
            return ["Address String ID is already in use."];
        }

        return $this->repo->update($id, $data);
    }
    public function delete(int $id): bool
    {
        if ($id <= 0) throw new InvalidArgumentException("Invalid ID");
        return $this->repo->delete($id);
    }
}
