<?php
namespace App\Service;
use App\Repository\DeliveryAddressToOnforwarderAddressMappingRepository;
use InvalidArgumentException;
class DeliveryAddressToOnforwarderAddressMappingService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new DeliveryAddressToOnforwarderAddressMappingRepository();
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
            'products' => $this->repo->getAllProducts()
        ];
    }
    public function create(array $data): bool|array
    {
        if ($this->repo->existsById((int)$data['id'])) {
            return ["Delivery Address To On forwarder Address Mapping ID is already in use."];
        }

        $this->repo->save($data);
        return true;
    }
    public function update(int $id, array $data): bool|array
    {
        if ((int)$id !== (int)$data['id'] && $this->repo->existsById((int)$data['id'])) {
            return ["Delivery Address To On forwarder Address Mapping ID is already in use."];
        }

        return $this->repo->update($id, $data);
    }
    public function delete(int $id): bool
    {
        if ($id <= 0) throw new InvalidArgumentException("Invalid ID");
        return $this->repo->delete($id);
    }
}
