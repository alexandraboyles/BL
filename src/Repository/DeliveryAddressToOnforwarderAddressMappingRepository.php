<?php
namespace App\Repository;

use PDO;
class DeliveryAddressToOnforwarderAddressMappingRepository
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
        $sql = "SELECT datoam.*, 
                       a.address_name AS address_name, 
                       c.customer_name AS customer_name,
                       p.title AS product_name
                  FROM deliveryAddressToOnforwarderAddressMapping datoam
             LEFT JOIN Address a ON datoam.address_id = a.id
             LEFT JOIN Customer c ON datoam.customer_id = c.id
             LEFT JOIN Product p ON datoam.product_id = p.id
              ORDER BY datoam.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT datoam.*, 
                   a.address_name AS address_name, 
                   c.customer_name AS customer_name,
                   p.title AS product_name
              FROM deliveryAddressToOnforwarderAddressMapping datoam
         LEFT JOIN Address a ON datoam.address_id = a.id
         LEFT JOIN Customer c ON datoam.customer_id = c.id
         LEFT JOIN Product p ON datoam.product_id = p.id
             WHERE datoam.id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    public function save(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO deliveryAddressToOnforwarderAddressMapping (id, address_id, customer_id, product_id)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([
            (int)$data['id'],
            $data['address_id'],
            $data['customer_id'],
            $data['product_id']
        ]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE deliveryAddressToOnforwarderAddressMapping
                SET id = ?, address_id = ?, customer_id = ?, product_id = ?
              WHERE id = ?"
        );
        return $stmt->execute([
            (int)$data['id'],
            $data['address_id'],
            $data['customer_id'],
            $data['product_id'],
            $id
        ]);
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM deliveryAddressToOnforwarderAddressMapping WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete delivery address to onforwarder address mapping: it is referenced by other data.");
            }
            throw $e;
        }
    }
    public function existsById(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM deliveryAddressToOnforwarderAddressMapping WHERE id = ?");
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn() > 0;
    }
    // New methods to populate dropdowns
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
}
