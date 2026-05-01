<?php
namespace App\Repository;

use PDO;
class AddressToInvoiceCustomerMappingRepository
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
        $sql = "SELECT aticm.*, 
                       a.address_name AS address_name, 
                       c.customer_name AS customer_name
                  FROM addressToInvoiceCustomerMapping aticm
             LEFT JOIN Address a ON aticm.address_id = a.id
             LEFT JOIN Customer c ON aticm.customer_id = c.id
              ORDER BY aticm.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT aticm.*, 
                   a.address_name AS address_name, 
                   c.customer_name AS customer_name
              FROM addressToInvoiceCustomerMapping aticm
         LEFT JOIN Address a ON aticm.address_id = a.id
         LEFT JOIN Customer c ON aticm.customer_id = c.id
             WHERE aticm.id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    public function save(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO addressToInvoiceCustomerMapping (id, address_id, customer_id)
             VALUES (?, ?, ?)"
        );
        $stmt->execute([
            $data['id'],
            $data['address_id'],
            $data['customer_id']
        ]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE addressToInvoiceCustomerMapping
                SET id = ?, address_id = ?, customer_id = ?
              WHERE id = ?"
        );
        return $stmt->execute([
            $data['id'],
            $data['address_id'],
            $data['customer_id'],
            $id
        ]);
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM addressToInvoiceCustomerMapping WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete address to invoice customer mapping: it is referenced by other data.");
            }
            throw $e;
        }
    }
    public function existsById(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM addressToInvoiceCustomerMapping WHERE id = ?");
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
}
