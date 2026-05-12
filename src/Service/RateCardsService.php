<?php
namespace App\Service;
use App\Repository\RateCardsRepository;
use InvalidArgumentException;
class RateCardsService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new RateCardsRepository();
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
        if ($this->repo->existsByRates($data['rates'])) {
            return ["Rates is already in use."];
        }

        $this->repo->save($data);
        return true;
    }
    public function update(int $id, array $data): bool|array
    {
        if ($this->repo->existsByRates(trim($data['rates']))) {
            return ["Rates is already in use."];
        }

        return $this->repo->update($id, $data);
    }
    public function delete(int $id): bool
    {
        if ($id <= 0) throw new InvalidArgumentException("Invalid ID");
        return $this->repo->delete($id);
    }
}
