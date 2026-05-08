<?php
namespace App\Service;
use App\Repository\ParsersRepository;
use InvalidArgumentException;
class ParsersService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new ParsersRepository();
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
            'customers' => $this->repo->getAllCustomers()
        ];
    }
    public function create(array $data): bool|array
    {
        if ($this->repo->existsById((int)$data['id'])) {
            return ["Parser ID is already in use."];
        }

        if ($this->repo->existsByParserName($data['parser_name'])) {
            return ["Parser Name is already in use."];
        }

        $this->repo->save($data);
        return true;
    }
    public function update(int $id, array $data): bool|array
    {
        if ((int)$id !== (int)$data['id'] && $this->repo->existsById((int)$data['id'])) {
            return ["Parser ID is already in use."];
        }

        if ($this->repo->existsByParserName($data['parser_name'], (string)$id)) {
            return ["Parser Name is already in use."];
        }

        return $this->repo->update($id, $data);
    }
    public function delete(int $id): bool
    {
        if ($id <= 0) throw new InvalidArgumentException("Invalid ID");
        return $this->repo->delete($id);
    }
}
