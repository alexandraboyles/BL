<?php
namespace App\Service;

use App\Repository\ContactsRepository;
use InvalidArgumentException;

class ContactsService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new ContactsRepository();
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
            'customers' => $this->repo->getAllCustomers()
        ];
    }

    public function create(array $data): bool|array
    {
        if ($this->repo->existsByContactName($data['contact_name'])) {
            return ["Contact name is already in use."];
        }

        $this->repo->save($data);
        return true;
    }

    public function update(string $originalContactId, array $data): bool|array
    {
        if ($this->repo->existsByContactName($data['contact_name'], (string)$originalContactId)) {
            return ["Contact Name is already in use."];
        }
        
        return $this->repo->update($originalContactId, $data);
    }

    public function delete(string $id): bool
    {
        if (trim($id) === '') {
            throw new InvalidArgumentException("Invalid ID");
        }
        return $this->repo->delete($id);
    }
}
