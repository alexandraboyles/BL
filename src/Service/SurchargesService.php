<?php
namespace App\Service;
use App\Repository\SurchargesRepository;
use InvalidArgumentException;
class SurchargesService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new SurchargesRepository();
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
            'feecategories' => $this->repo->getAllFeeCategories()
        ];
    }
    public function create(array $data): bool|array
    {
        if ($this->repo->existsBySurchargeName($data['surcharge_name'])) {
            return ["Surcharge Name is already in use."];
        }

        $this->repo->save($data);
        return true;
    }
    public function update(int $id, array $data): bool|array
    {
        if ($this->repo->existsBySurchargeName($data['surcharge_name'], (string)$id)) {
            return ["Surcharge Name is already in use."];
        }

        return $this->repo->update($id, $data);
    }
    public function delete(int $id): bool
    {
        if ($id <= 0) throw new InvalidArgumentException("Invalid ID");
        return $this->repo->delete($id);
    }
}
