<?php
namespace App\Repository;

use PDO;
class AddressDefaultInstructionsRepository
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
        $stmt = $this->pdo->query("SELECT * FROM addressDefaultInstruction ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT adi.*, 
                   a.address_name AS address_name, 
                   c.customer_name AS customer_name
              FROM addressDefaultInstruction adi
         LEFT JOIN Address a ON adi.address_id = a.id
         LEFT JOIN Customer c ON adi.customer_id = c.id
             WHERE adi.id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    public function save(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO addressDefaultInstruction (address_id, customer_id, deliveryInstruction, packingInstruction)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['address_id'],
            $data['customer_id'],
            trim($data['deliveryInstruction']),
            trim($data['packingInstruction'])
        ]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE addressDefaultInstruction 
                SET address_id = ?, customer_id = ?, 
                    deliveryInstruction = ?, packingInstruction = ?
              WHERE id = ?"
        );
        return $stmt->execute([
            $data['address_id'],
            $data['customer_id'],
            trim($data['deliveryInstruction']),
            trim($data['packingInstruction']),
            $id
        ]);
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM addressDefaultInstruction WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation (e.g., foreign key)
                throw new \Exception("Cannot delete address default instruction: it is referenced by other data.");
            }
            throw $e;
        }
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
