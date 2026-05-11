<?php
namespace App\Repository;

use PDO;
class AddressToDeliveryRunMappingRepository
{
    private PDO $pdo;
    public function __construct()
    {
        global $pdo;
        if (!isset($pdo)) {
            throw new \RuntimeException("Database connection not available");
        }
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $sql = "SELECT atdrm.*, 
                       adt.addressType_name AS addressType_name, 
                       a.address_name AS address_name,
                       c.customer_name AS customer_name,
                       p.title AS product_name,
                       dr.deliveryRun_name AS deliveryRun_name,
                       cr.carrier_name AS carrier_name,
                       fd.flowDirection AS flow_direction
                  FROM addressToDeliveryRunMapping atdrm
             LEFT JOIN addressType adt ON atdrm.addressType_id = adt.id
             LEFT JOIN Address a ON atdrm.address_id = a.id
             LEFT JOIN Customer c ON atdrm.customer_id = c.id
             LEFT JOIN Product p ON atdrm.product_id = p.id
             LEFT JOIN deliveryRun dr ON atdrm.deliveryRun_id = dr.id
             LEFT JOIN carrier cr ON atdrm.carrier_id = cr.id
             LEFT JOIN flowDirection fd ON atdrm.flowDirection_id = fd.id
              ORDER BY atdrm.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT atdrm.*, 
                   adt.addressType_name AS addressType_name, 
                   a.address_name AS address_name,
                   c.customer_name AS customer_name,
                   p.title AS product_name,
                   dr.deliveryRun_name AS deliveryRun_name,
                   cr.carrier_name AS carrier_name,
                   fd.flowDirection AS flow_direction
              FROM addressToDeliveryRunMapping atdrm
         LEFT JOIN addressType adt ON atdrm.addressType_id = adt.id
         LEFT JOIN Address a ON atdrm.address_id = a.id
         LEFT JOIN Customer c ON atdrm.customer_id = c.id
         LEFT JOIN Product p ON atdrm.product_id = p.id
         LEFT JOIN deliveryRun dr ON atdrm.deliveryRun_id = dr.id
         LEFT JOIN carrier cr ON atdrm.carrier_id = cr.id
         LEFT JOIN flowDirection fd ON atdrm.flowDirection_id = fd.id
             WHERE atdrm.id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    public function save(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO addressToDeliveryRunMapping (id, addressType_id, address_id, customer_id, product_id, deliveryRun_id, carrier_id, flowDirection_id)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            (int)$data['id'],
            (int)$data['addressType_id'],
            $data['address_id'],
            $data['customer_id'],
            $data['product_id'],
            $data['deliveryRun_id'],
            $data['carrier_id'],
            $data['flowDirection_id']
        ]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE addressToDeliveryRunMapping
                SET id = ?, addressType_id = ?, address_id = ?, customer_id = ?, product_id = ?, deliveryRun_id = ?, carrier_id = ?, flowDirection_id = ?
              WHERE id = ?"
        );
        return $stmt->execute([
            (int)$data['id'],
            (int)$data['addressType_id'],
            $data['address_id'],
            $data['customer_id'],
            $data['product_id'],
            $data['deliveryRun_id'],
            $data['carrier_id'],
            $data['flowDirection_id'],
            $id
        ]);
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM addressToDeliveryRunMapping WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete address to delivery run mapping: it is referenced by other data.");
            }
            throw $e;
        }
    }
    public function existsById(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM addressToDeliveryRunMapping WHERE id = ?");
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn() > 0;
    }
    // New methods to populate dropdowns
    public function getAllAddressTypes(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM addressType ORDER BY addressType_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllAddresses(): array
    {
        $stmt = $this->pdo->query("SELECT id, address_name FROM Address ORDER BY address_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllCustomers(): array
    {
        $stmt = $this->pdo->query("SELECT id, customer_name FROM Customer ORDER BY customer_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProducts(): array
    {
        $stmt = $this->pdo->query("SELECT id, title FROM Product ORDER BY title");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllDeliveryRuns(): array
    {
        $stmt = $this->pdo->query("SELECT id, deliveryRun_name FROM deliveryRun ORDER BY deliveryRun_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        public function getAllCarriers(): array
    {
        $stmt = $this->pdo->query("SELECT id, carrier_name FROM carrier ORDER BY carrier_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        public function getAllFlowDirections(): array
    {
        $stmt = $this->pdo->query("SELECT id, flowDirection FROM flowDirection ORDER BY flowDirection");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
