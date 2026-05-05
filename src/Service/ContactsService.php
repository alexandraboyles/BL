<?php
namespace App\Service;

use App\Repository\ContactsRepository;
use App\Validation\ContactsValidator;
use InvalidArgumentException;

class ContactsService
{
    private $repo;
    private $validator;

    public function __construct()
    {
        $this->repo = new ContactsRepository();
        $this->validator = new ContactsValidator();
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
            'customers' => $this->repo->getAllCustomers()
        ];
    }

    public function create(array $data): bool|array
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
        }

        if ($this->repo->existsByContactName(trim($data['contact_name']))) {
            return ["Contact name is already in use."];
        }

        $this->repo->save($data);
        return true;
    }

    public function update(string $originalContactId, array $data): bool|array
    {
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return $errors;
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
