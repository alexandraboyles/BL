<?php
namespace App\Service;
use App\Repository\AccountsRepository;
use InvalidArgumentException;
class AccountsService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new AccountsRepository();
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
        if ($this->repo->existsByAccountName($data['account_name'])) {
            return ["Account Name is already in use."];
        }

        $this->repo->save($data);
        return true;
    }
    public function update(int $originalId, array $data): bool|array
    {
        if ($this->repo->existsByAccountName($data['account_name'], (string)$originalId)) {
            return ["Account Name is already in use."];
        }

        return $this->repo->update($originalId, $data);
    }
    public function delete(int $id): bool
    {
        if ($id <= 0) throw new InvalidArgumentException("Invalid ID");
        return $this->repo->delete($id);
    }
}
