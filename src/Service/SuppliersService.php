<?php
namespace App\Service;
use App\Repository\SuppliersRepository;
use InvalidArgumentException;
class SuppliersService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new SuppliersRepository();
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
            'rateCards' => $this->repo->getAllRateCards()
        ];
    }
    public function create(array $data): bool|array
    {
        if ($this->repo->existsByCompanyName($data['companyName'])) {
            return ["Company Name is already in use."];
        }

        if ($this->repo->existsByEmail($data['email'])) {
            return ["Email is already in use."];
        }

        $this->repo->save($data);
        return true;
    }
    public function update(int $id, array $data): bool|array
    {
        if ($this->repo->existsByCompanyName(trim($data['companyName']), (int)$id)) {
            return ["Company Name is already in use."];
        }
        if ($this->repo->existsByEmail(trim($data['email']), (int)$id)) {
            return ["Email is already in use."];
        }

        return $this->repo->update($id, $data);
    }
    public function delete(int $id): bool
    {
        if ($id <= 0) throw new InvalidArgumentException("Invalid ID");
        return $this->repo->delete($id);
    }
}
